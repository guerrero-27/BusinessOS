<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['type', 'date_from', 'date_to']);

        $movementQuery = InventoryMovement::query()->with(['product', 'user'])
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->latest('created_at');

        $movements = $movementQuery->take(8)->get();

        $summary = [
            'customers_total' => Customer::count(),
            'customers_active' => Customer::where('is_active', true)->count(),
            'products_total' => Product::where('status', '!=', 'archived')->count(),
            'products_low' => Product::whereRaw('current_stock > 0 AND current_stock <= min_stock')->count(),
            'products_out' => Product::where('current_stock', '<=', 0)->count(),
            'categories_active' => Category::where('is_active', true)->count(),
            'movements_total' => InventoryMovement::count(),
            'movements_in' => InventoryMovement::where('type', 'in')->count(),
            'movements_out' => InventoryMovement::where('type', 'out')->count(),
            'movements_adjustment' => InventoryMovement::where('type', 'adjustment')->count(),
        ];

        $recentCustomers = Customer::latest()->take(5)->get();
        $lowStockProducts = Product::whereRaw('current_stock > 0 AND current_stock <= min_stock')
            ->where('status', '!=', 'archived')
            ->orderBy('current_stock')
            ->take(5)
            ->get();

        // Movement volume for the last 7 days, used to draw the trend chart.
        $trendDays = collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo)->toDateString());
        $movementTrend = $trendDays->map(function ($date) {
            return [
                'date'  => $date,
                'label' => \Illuminate\Support\Carbon::parse($date)->format('D'),
                'count' => InventoryMovement::whereDate('created_at', $date)->count(),
            ];
        });

        return view('reports.index', compact(
            'movements', 'summary', 'recentCustomers', 'lowStockProducts', 'filters', 'movementTrend'
        ));
    }
}
