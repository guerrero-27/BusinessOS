<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('customers', CustomerController::class);

Route::get('/dashboard', function () {
    $customerStats = [
        'total'    => \App\Models\Customer::count(),
        'active'   => \App\Models\Customer::where('is_active', true)->count(),
        'inactive' => \App\Models\Customer::where('is_active', false)->count(),
        'new'      => \App\Models\Customer::whereMonth('created_at', now()->month)->count(),
    ];
    $recentCustomers = \App\Models\Customer::latest()->take(5)->get();
    return view('dashboard', compact('customerStats', 'recentCustomers'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
