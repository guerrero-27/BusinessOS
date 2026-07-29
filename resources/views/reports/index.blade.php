<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-gradient-to-r from-indigo-600 to-slate-900 p-6 text-white shadow-sm sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-indigo-100">Insights</p>
                <h1 class="mt-2 text-2xl font-semibold">Reports</h1>
                <p class="mt-2 max-w-2xl text-sm text-indigo-100">Track customer activity, stock movement, and operational health from one place.</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm backdrop-blur">
                <p class="text-indigo-100">Inventory movement</p>
                <p class="mt-1 text-xl font-semibold">{{ $summary['movements_total'] }} entries</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-gray-500">Customers</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-2xl font-semibold text-gray-900">{{ $summary['customers_total'] }}</p>
                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ $summary['customers_active'] }} active</span>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-gray-500">Products</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-2xl font-semibold text-gray-900">{{ $summary['products_total'] }}</p>
                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">{{ $summary['products_low'] }} low stock</span>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-gray-500">Out of stock</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-2xl font-semibold text-gray-900">{{ $summary['products_out'] }}</p>
                    <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">Needs attention</span>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-gray-500">Categories</p>
                <div class="mt-3 flex items-end justify-between">
                    <p class="text-2xl font-semibold text-gray-900">{{ $summary['categories_active'] }}</p>
                    <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700">Active</span>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Inventory movement</h2>
                        <p class="text-sm text-gray-500">Recent stock changes and adjustments.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs font-medium">
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-emerald-700">In: {{ $summary['movements_in'] }}</span>
                        <span class="rounded-full bg-rose-50 px-2.5 py-1 text-rose-700">Out: {{ $summary['movements_out'] }}</span>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-700">Adjust: {{ $summary['movements_adjustment'] }}</span>
                    </div>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse ($movements as $movement)
                        <div class="flex flex-col gap-2 rounded-xl border border-gray-100 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $movement->product?->name ?? 'Unknown product' }}</p>
                                <p class="text-sm text-gray-500">{{ $movement->reason ?: 'No reason provided' }} · {{ $movement->reference_number }}</p>
                            </div>
                            <div class="text-sm">
                                <span class="rounded-full px-2.5 py-1 font-medium {{ $movement->type === 'in' ? 'bg-emerald-50 text-emerald-700' : ($movement->type === 'out' ? 'bg-rose-50 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                                    {{ strtoupper($movement->type) }}
                                </span>
                                <span class="ml-2 text-gray-500">{{ $movement->quantity }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-200 p-6 text-center text-sm text-gray-500">
                            No inventory movement recorded yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">Recent customers</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($recentCustomers as $customer)
                            <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-slate-50 px-3 py-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                </div>
                                <span class="rounded-full {{ $customer->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }} px-2.5 py-1 text-xs font-medium">
                                    {{ $customer->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No customers yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">Low stock products</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($lowStockProducts as $product)
                            <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-slate-50 px-3 py-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                                </div>
                                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                                    {{ $product->current_stock }} left
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">All products are well stocked.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
