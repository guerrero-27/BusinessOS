<x-app-layout>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Reports</h1>
            <p class="text-sm text-gray-400 mt-0.5">Customer activity, stock levels, and inventory movement at a glance.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 text-gray-500 text-xs font-medium rounded-lg">
                {{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </div>

    {{-- KPI Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Customers</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $summary['customers_total'] }}</p>
            <p class="text-xs text-green-600 mt-1">{{ $summary['customers_active'] }} active</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Products</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $summary['products_total'] }}</p>
            <p class="text-xs text-yellow-600 mt-1">{{ $summary['products_low'] }} low stock</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Out of Stock</p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $summary['products_out'] }}</p>
            <p class="text-xs text-gray-400 mt-1">Needs restocking</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Active Categories</p>
            <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $summary['categories_active'] }}</p>
            <p class="text-xs text-gray-400 mt-1">&nbsp;</p>
        </div>
    </div>

    {{-- Movement trend + breakdown --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-700 mb-4">Movement Trend (Last 7 Days)</p>
            <div class="h-32 flex items-end gap-2">
                @php $trendMax = max($movementTrend->pluck('count')->max(), 1); @endphp
                @foreach ($movementTrend as $day)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-indigo-500 rounded-t" style="height: {{ round(($day['count'] / $trendMax) * 100) }}%; min-height: {{ $day['count'] > 0 ? '4px' : '0' }}"></div>
                        <span class="text-xs text-gray-400">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-700 mb-4">Movement Breakdown</p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-sm text-gray-600"><span class="w-2.5 h-2.5 rounded-sm bg-emerald-500 inline-block"></span> Stock In</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $summary['movements_in'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-sm text-gray-600"><span class="w-2.5 h-2.5 rounded-sm bg-rose-500 inline-block"></span> Stock Out</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $summary['movements_out'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-sm text-gray-600"><span class="w-2.5 h-2.5 rounded-sm bg-slate-400 inline-block"></span> Adjustments</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $summary['movements_adjustment'] }}</span>
                </div>
                <div class="pt-3 mt-3 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Total entries</span>
                    <span class="text-sm font-semibold text-indigo-600">{{ $summary['movements_total'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Inventory movement (filterable) --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-8">
        <div class="px-5 py-3 border-b border-gray-100 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-semibold text-gray-700">Inventory Movement</p>
            <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-2">
                <select name="type" class="rounded-lg border-gray-200 text-sm text-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All types</option>
                    <option value="in" @selected(($filters['type'] ?? '') === 'in')>Stock In</option>
                    <option value="out" @selected(($filters['type'] ?? '') === 'out')>Stock Out</option>
                    <option value="adjustment" @selected(($filters['type'] ?? '') === 'adjustment')>Adjustment</option>
                </select>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="rounded-lg border-gray-200 text-sm text-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="rounded-lg border-gray-200 text-sm text-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit" class="px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Filter</button>
                @if (array_filter($filters))
                    <a href="{{ route('reports.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                @endif
            </form>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse ($movements as $movement)
                <div class="px-5 py-3 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 text-sm font-semibold
                            {{ $movement->type === 'in' ? 'bg-emerald-50 text-emerald-600' : ($movement->type === 'out' ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-600') }}">
                            {{ $movement->type === 'in' ? '+' : ($movement->type === 'out' ? '−' : '~') }}
                        </span>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $movement->product?->name ?? 'Unknown product' }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $movement->reason ?: 'No reason provided' }} · {{ $movement->reference_number }}</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full
                            {{ $movement->type === 'in' ? 'bg-emerald-50 text-emerald-700' : ($movement->type === 'out' ? 'bg-rose-50 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                            {{ $movement->quantity }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $movement->created_at->format('M j, g:i A') }}</p>
                    </div>
                </div>
            @empty
                <div class="px-5 py-6 text-center text-sm text-gray-400">No inventory movement recorded for these filters.</div>
            @endforelse
        </div>
    </div>

    {{-- Bottom grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-700">Recent Customers</p>
                <a href="{{ route('customers.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">View all →</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($recentCustomers as $customer)
                    <div class="px-5 py-3 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                            <p class="text-xs text-gray-400 break-all">{{ $customer->email }}</p>
                        </div>
                        @if ($customer->is_active)
                            <span class="text-xs bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">Active</span>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-400 border border-gray-200 px-2 py-0.5 rounded-full">Inactive</span>
                        @endif
                    </div>
                @empty
                    <div class="px-5 py-6 text-center text-sm text-gray-400">No customers yet.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-700">Low Stock Products</p>
                <a href="{{ route('inventory.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">View all →</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($lowStockProducts as $product)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-700">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $product->sku }}</p>
                        </div>
                        <span class="text-xs font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 px-2 py-0.5 rounded-full">
                            {{ $product->current_stock }} left
                        </span>
                    </div>
                @empty
                    <div class="px-5 py-6 text-center text-sm text-gray-400">All products are well-stocked.</div>
                @endforelse
            </div>
        </div>
    </div>

</x-app-layout>
