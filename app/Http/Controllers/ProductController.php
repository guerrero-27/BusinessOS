<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->withTrashed(false);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('stock_status')) {
            match ($request->stock_status) {
                'low_stock'    => $query->whereRaw('current_stock > 0 AND current_stock <= min_stock'),
                'out_of_stock' => $query->where('current_stock', '<=', 0),
                'in_stock'     => $query->whereRaw('current_stock > min_stock'),
                default        => null,
            };
        }

        $sortField = $request->get('sort', 'created_at');
        $sortDir   = $request->get('dir', 'desc');
        $allowedSorts = ['name', 'sku', 'selling_price', 'current_stock', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) $sortField = 'created_at';

        $perPage  = $request->get('per_page', 10);
        $products = $query->orderBy($sortField, $sortDir)->paginate($perPage)->withQueryString();

        $totalProducts    = Product::count();
        $activeProducts   = Product::where('status', 'active')->count();
        $lowStockProducts = Product::whereRaw('current_stock > 0 AND current_stock <= min_stock')->count();
        $outOfStock       = Product::where('current_stock', '<=', 0)->count();
        $draftProducts    = Product::where('status', 'draft')->count();
        $archivedProducts = Product::where('status', 'archived')->count();
        $inactiveProducts = Product::where('status', 'inactive')->count();

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $recentActivities = Product::latest()->take(5)->get()->map(fn($p) => [
            'type'    => 'created',
            'product' => $p->name,
            'time'    => $p->created_at->diffForHumans(),
        ]);

        $lowStockPanel = Product::whereRaw('current_stock <= min_stock')
            ->orderBy('current_stock')
            ->take(5)
            ->get();

        $newestProduct = Product::latest()->first();

        return view('products.index', compact(
            'products', 'categories',
            'totalProducts', 'activeProducts', 'lowStockProducts', 'outOfStock',
            'draftProducts', 'archivedProducts', 'inactiveProducts',
            'recentActivities', 'lowStockPanel', 'newestProduct'
        ));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
