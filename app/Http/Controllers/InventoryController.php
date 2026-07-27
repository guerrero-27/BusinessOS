<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Http\Requests\StoreInventoryMovementRequest;
use App\Services\ReferenceNumberService;
use App\Services\BarcodeService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $stockQuery = Product::with('category')->where('status', '!=', 'archived');

        if ($request->filled('search')) {
            $stockQuery->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $stockQuery->where('category_id', $request->category);
        }

        if ($request->filled('stock_status')) {
            match ($request->stock_status) {
                'low_stock'    => $stockQuery->whereRaw('current_stock > 0 AND current_stock <= min_stock'),
                'out_of_stock' => $stockQuery->where('current_stock', '<=', 0),
                'in_stock'     => $stockQuery->whereRaw('current_stock > min_stock'),
                default        => null,
            };
        }

        $products = $stockQuery->orderBy('name')->paginate(15)->withQueryString();

        $movementsQuery = InventoryMovement::with('product', 'user')
            ->when($request->filled('product_id'), fn($q) => $q->where('product_id', $request->product_id))
            ->when($request->filled('movement_type'), fn($q) => $q->where('type', $request->movement_type))
            ->when($request->filled('ref_search'), fn($q) => $q->where('reference_number', 'like', '%' . $request->ref_search . '%'))
            ->latest();

        $movements = $movementsQuery->paginate(10, ['*'], 'mpage')->withQueryString();

        $totalProducts   = Product::where('status', '!=', 'archived')->count();
        $inStockCount    = Product::whereRaw('current_stock > min_stock')->count();
        $lowStockCount   = Product::whereRaw('current_stock > 0 AND current_stock <= min_stock')->count();
        $outOfStockCount = Product::where('current_stock', '<=', 0)->count();

        $categories  = Category::where('is_active', true)->orderBy('name')->get();
        $allProducts = Product::where('status', 'active')->orderBy('name')->get();

        return view('inventory.index', compact(
            'products', 'movements', 'categories', 'allProducts',
            'totalProducts', 'inStockCount', 'lowStockCount', 'outOfStockCount'
        ));
    }

    public function store(StoreInventoryMovementRequest $request, ReferenceNumberService $refService)
    {
        $product     = Product::findOrFail($request->product_id);
        $stockBefore = $product->current_stock;
        $qty         = (int) $request->quantity;

        $stockAfter = match ($request->type) {
            'in'         => $stockBefore + $qty,
            'out'        => max(0, $stockBefore - $qty),
            'adjustment' => $qty,
        };

        $qtyChange = match ($request->type) {
            'in'         => $qty,
            'out'        => -($stockBefore - $stockAfter),
            'adjustment' => $stockAfter - $stockBefore,
        };

        InventoryMovement::create([
            'product_id'       => $product->id,
            'type'             => $request->type,
            'quantity'         => $qtyChange,
            'stock_before'     => $stockBefore,
            'stock_after'      => $stockAfter,
            'reason'           => $request->reason,
            'reference_number' => $refService->generate($request->type),
            'user_id'          => auth()->id(),
        ]);

        $product->update(['current_stock' => $stockAfter]);

        return redirect()->route('inventory.index')->with('success', 'Stock updated successfully.');
    }

    public function barcodeLabel(Product $product, BarcodeService $barcodeService)
    {
        $barcodeSvg = $barcodeService->generateSvg($product->barcode);
        return view('inventory.barcode-label', compact('product', 'barcodeSvg'));
    }
}
