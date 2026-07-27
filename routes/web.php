<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SkuPreviewController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class)->except(['show', 'create', 'edit']);
Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/barcode/{product}', [InventoryController::class, 'barcodeLabel'])->name('inventory.barcode');
Route::get('/products/sku-preview', [SkuPreviewController::class, '__invoke'])->name('products.sku-preview');

Route::get('/dashboard', function () {
    $customerStats = [
        'total'    => \App\Models\Customer::count(),
        'active'   => \App\Models\Customer::where('is_active', true)->count(),
        'inactive' => \App\Models\Customer::where('is_active', false)->count(),
        'new'      => \App\Models\Customer::whereMonth('created_at', now()->month)->count(),
    ];
    $recentCustomers = \App\Models\Customer::latest()->take(5)->get();
    $inventoryStats = [
        'total'         => \App\Models\Product::where('status', '!=', 'archived')->count(),
        'low_stock'     => \App\Models\Product::whereRaw('current_stock > 0 AND current_stock <= min_stock')->count(),
        'out_of_stock'  => \App\Models\Product::where('current_stock', '<=', 0)->count(),
    ];
    $lowStockProducts = \App\Models\Product::whereRaw('current_stock <= min_stock')
        ->where('status', '!=', 'archived')
        ->orderBy('current_stock')
        ->take(5)
        ->get();
    return view('dashboard', compact('customerStats', 'recentCustomers', 'inventoryStats', 'lowStockProducts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
