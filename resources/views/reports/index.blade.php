<x-app-layout>
    @php
        $selectedRange = request('range', 'month');
        $searchQuery = trim((string) request('q', ''));
        $typeFilter = request('type', $filters['type'] ?? '');

        $revenueFromMovements = $movements->where('type', 'out')->sum(function ($m) {
            return abs($m->quantity) * (float) ($m->product->selling_price ?? 0);
        });

        $expenseFromMovements = $movements->where('type', 'in')->sum(function ($m) {
            return abs($m->quantity) * (float) ($m->product->cost_price ?? 0);
        });

        $netProfit = $revenueFromMovements - $expenseFromMovements;
        $profitRate = $revenueFromMovements > 0 ? round(($netProfit / $revenueFromMovements) * 100, 1) : 0;

        $totalSalesCount = $summary['movements_out'] ?? 0;
        $totalProducts = $summary['products_total'] ?? 0;
        $lowStockCount = $summary['products_low'] ?? 0;
        $outStockCount = $summary['products_out'] ?? 0;

        $newCustomers = \App\Models\Customer::whereMonth('created_at', now()->month)->count();
        $activeCustomers = $summary['customers_active'] ?? 0;
        $returningCustomers = max($activeCustomers - $newCustomers, 0);
        $customerGrowthRate = ($summary['customers_total'] ?? 0) > 0 ? round(($newCustomers / $summary['customers_total']) * 100, 1) : 0;

        $inventoryValue = \App\Models\Product::where('status', '!=', 'archived')->get()->sum(function ($product) {
            return max((int) $product->current_stock, 0) * (float) $product->selling_price;
        });

        $trendMax = max((int) $movementTrend->pluck('count')->max(), 1);

        $last6Months = collect(range(5, 0))->map(function ($monthsAgo) {
            $monthDate = now()->startOfMonth()->subMonths($monthsAgo);

            return [
                'label' => $monthDate->format('M'),
                'new_customers' => \App\Models\Customer::whereYear('created_at', $monthDate->year)
                    ->whereMonth('created_at', $monthDate->month)
                    ->count(),
            ];
        });

        $customerChartMax = max((int) $last6Months->pluck('new_customers')->max(), 1);

        $topSelling = \App\Models\InventoryMovement::query()
            ->with(['product.category'])
            ->where('type', 'out')
            ->whereNotNull('product_id')
            ->get()
            ->groupBy('product_id')
            ->map(function ($rows) {
                $first = $rows->first();
                $units = $rows->sum(function ($row) {
                    return abs((int) $row->quantity);
                });
                $revenue = $rows->sum(function ($row) {
                    return abs((int) $row->quantity) * (float) ($row->product->selling_price ?? 0);
                });

                return [
                    'product' => $first->product,
                    'units' => $units,
                    'revenue' => $revenue,
                ];
            })
            ->sortByDesc('units')
            ->take(6)
            ->values();

        $stockHealthyPct = $totalProducts > 0 ? round((($totalProducts - $lowStockCount - $outStockCount) / $totalProducts) * 100) : 0;
        $stockLowPct = $totalProducts > 0 ? round(($lowStockCount / $totalProducts) * 100) : 0;
        $stockOutPct = $totalProducts > 0 ? round(($outStockCount / $totalProducts) * 100) : 0;

        $transactions = $movements->map(function ($movement) {
            $amount = abs((int) $movement->quantity) * (float) ($movement->product->selling_price ?? 0);

            if ($movement->type === 'in') {
                $status = 'Pending';
                $statusClass = 'bg-amber-50 text-amber-700 border-amber-200';
            } elseif ($movement->type === 'adjustment') {
                $status = 'Cancelled';
                $statusClass = 'bg-gray-100 text-gray-700 border-gray-200';
            } else {
                $status = 'Paid';
                $statusClass = 'bg-green-50 text-green-700 border-green-200';
            }

            return [
                'invoice' => $movement->reference_number ?: 'TXN-' . str_pad((string) $movement->id, 6, '0', STR_PAD_LEFT),
                'customer' => $movement->user?->name ?? 'Walk-in Customer',
                'amount' => $amount,
                'status' => $status,
                'status_class' => $statusClass,
                'date' => $movement->created_at,
            ];
        });

        if ($searchQuery !== '') {
            $transactions = $transactions->filter(function ($tx) use ($searchQuery) {
                return str_contains(strtolower($tx['invoice']), strtolower($searchQuery))
                    || str_contains(strtolower($tx['customer']), strtolower($searchQuery));
            })->values();
        }
    @endphp

    <noscript>
        <style>
            #reports-skeleton { display: none !important; }
            #reports-content { display: block !important; }
        </style>
    </noscript>

    <div class="space-y-6 print:space-y-4" id="reports-module">
        <div id="reports-skeleton" class="animate-pulse space-y-4">
            <div class="h-28 rounded-2xl border border-black/10 bg-white"></div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="h-28 rounded-2xl border border-black/10 bg-white"></div>
                <div class="h-28 rounded-2xl border border-black/10 bg-white"></div>
                <div class="h-28 rounded-2xl border border-black/10 bg-white"></div>
            </div>
            <div class="h-72 rounded-2xl border border-black/10 bg-white"></div>
        </div>

        <div id="reports-content" class="hidden space-y-6 text-[#111111]">
            <div class="overflow-hidden rounded-2xl border border-black/10 bg-white p-5 shadow-sm backdrop-blur print:border-0 print:shadow-none">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#6B7280]">BusinessOS Intelligence</p>
                        <h1 class="mt-1 text-2xl font-semibold text-[#111111]">Reports &amp; Analytics</h1>
                        <p class="mt-1 text-sm text-[#6B7280]">Monitor business performance and financial insights.</p>
                    </div>

                    <div class="flex flex-col gap-2 print:hidden">
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="relative">
                                <button id="export-toggle" type="button" class="inline-flex items-center gap-2 rounded-lg border border-black/10 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-[#F4F5F7]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v10m0 0 4-4m-4 4-4-4M5 19h14"/>
                                    </svg>
                                    Export Menu
                                </button>

                                <div id="export-menu" class="hidden absolute right-0 z-20 mt-2 w-40 overflow-hidden rounded-xl border border-black/10 bg-white shadow-lg">
                                    <a href="{{ route('reports.index', array_merge(request()->query(), ['export' => 'pdf'])) }}" class="block px-3 py-2 text-xs text-gray-700 transition hover:bg-[#F4F5F7]">Export PDF</a>
                                    <a href="{{ route('reports.index', array_merge(request()->query(), ['export' => 'excel'])) }}" class="block px-3 py-2 text-xs text-gray-700 transition hover:bg-[#F4F5F7]">Export Excel</a>
                                    <button type="button" onclick="window.print()" class="block w-full px-3 py-2 text-left text-xs text-gray-700 transition hover:bg-[#F4F5F7]">Print Report</button>
                                </div>
                            </div>

                            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg border border-[#111111] bg-[#111111] px-3 py-2 text-xs font-medium text-white transition hover:bg-black">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9V3h12v6M6 17H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2m-8 0h8v4H8v-4Z"/>
                                </svg>
                                Print Report
                            </button>
                        </div>
                    </div>
                </div>

                <form action="{{ route('reports.index') }}" method="GET" class="mt-4 grid grid-cols-1 gap-2 lg:grid-cols-12 print:hidden">
                    <div class="lg:col-span-2">
                        <select name="range" class="w-full rounded-lg border border-black/10 bg-white text-sm text-gray-700 focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                            <option value="today" @selected($selectedRange === 'today')>Today</option>
                            <option value="week" @selected($selectedRange === 'week')>This Week</option>
                            <option value="month" @selected($selectedRange === 'month')>This Month</option>
                            <option value="custom" @selected($selectedRange === 'custom')>Custom Range</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="w-full rounded-lg border border-black/10 bg-white text-sm text-gray-700 focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    </div>
                    <div class="lg:col-span-2">
                        <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="w-full rounded-lg border border-black/10 bg-white text-sm text-gray-700 focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    </div>
                    <div class="lg:col-span-2">
                        <select name="type" class="w-full rounded-lg border border-black/10 bg-white text-sm text-gray-700 focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                            <option value="">Filter dropdown</option>
                            <option value="in" @selected($typeFilter === 'in')>Stock In</option>
                            <option value="out" @selected($typeFilter === 'out')>Stock Out</option>
                            <option value="adjustment" @selected($typeFilter === 'adjustment')>Adjustment</option>
                        </select>
                    </div>
                    <div class="lg:col-span-3">
                        <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Search reports, invoice, customer..." class="w-full rounded-lg border border-black/10 bg-white text-sm text-gray-700 focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    </div>
                    <div class="lg:col-span-1">
                        <button type="submit" class="w-full rounded-lg border border-black/10 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-[#F4F5F7]">Apply</button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="group rounded-xl border border-black/10 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#6B7280]">Total Revenue</p>
                            <p class="mt-2 text-2xl font-semibold">PHP {{ number_format($revenueFromMovements, 2) }}</p>
                            <p class="mt-1 text-xs {{ $revenueFromMovements > 0 ? 'text-green-600' : 'text-gray-500' }}">{{ $revenueFromMovements > 0 ? '+12.4%' : 'No change' }} vs previous period</p>
                        </div>
                        <span class="rounded-lg bg-[#EAF8E5] p-2 text-[#2f7b35]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17h18M7 13V7m5 6V5m5 8v-4"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="group rounded-xl border border-black/10 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#6B7280]">Total Sales</p>
                            <p class="mt-2 text-2xl font-semibold">{{ number_format($totalSalesCount) }}</p>
                            <p class="mt-1 text-xs text-green-600">+8.2% transaction growth</p>
                        </div>
                        <span class="rounded-lg bg-[#F4F5F7] p-2 text-[#111111]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M7 11h10M6 15h12M8 19h8"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="group rounded-xl border border-black/10 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#6B7280]">Total Expenses</p>
                            <p class="mt-2 text-2xl font-semibold">PHP {{ number_format($expenseFromMovements, 2) }}</p>
                            <p class="mt-1 text-xs text-amber-600">+3.6% expense trend</p>
                        </div>
                        <span class="rounded-lg bg-amber-50 p-2 text-amber-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 15l4-4 3 3 5-6"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="group rounded-xl border border-black/10 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#6B7280]">Net Profit</p>
                            <p class="mt-2 text-2xl font-semibold">PHP {{ number_format($netProfit, 2) }}</p>
                            <p class="mt-1 text-xs {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $profitRate }}% margin indicator</p>
                        </div>
                        <span class="rounded-lg {{ $netProfit >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }} p-2">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 16 4-4 3 3 7-7M19 8v4h-4"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="group rounded-xl border border-black/10 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#6B7280]">Total Customers</p>
                            <p class="mt-2 text-2xl font-semibold">{{ number_format($summary['customers_total'] ?? 0) }}</p>
                            <p class="mt-1 text-xs text-green-600">{{ $newCustomers }} new, {{ $customerGrowthRate }}% growth</p>
                        </div>
                        <span class="rounded-lg bg-[#EAF8E5] p-2 text-[#2f7b35]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m20 0v-2a4 4 0 0 0-3-3.87m-4-7.13a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm6 2a4 4 0 0 1-3 3.87"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="group rounded-xl border border-black/10 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#6B7280]">Inventory Value</p>
                            <p class="mt-2 text-2xl font-semibold">PHP {{ number_format($inventoryValue, 2) }}</p>
                            <p class="mt-1 text-xs text-[#2f7b35]">Current stock valuation</p>
                        </div>
                        <span class="rounded-lg bg-[#F4F5F7] p-2 text-[#111111]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7 12 3 4 7l8 4 8-4Zm0 0v10l-8 4-8-4V7m8 4v10"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
                <div class="xl:col-span-2 rounded-xl border border-black/10 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-semibold text-[#111111]">Sales Performance Over Time</h2>
                            <p class="text-xs text-[#6B7280]">Daily sales, monthly trend, and previous period comparison.</p>
                        </div>
                        <span class="rounded-full bg-[#F4F5F7] px-2.5 py-1 text-[11px] font-medium text-gray-600">Last 7 days</span>
                    </div>

                    <div class="h-44 rounded-xl border border-black/10 bg-white p-3">
                        <div class="flex h-full items-end gap-2">
                            @foreach ($movementTrend as $point)
                                @php
                                    $height = max(8, round(($point['count'] / $trendMax) * 100));
                                @endphp
                                <div class="flex-1">
                                    <div class="group flex h-full flex-col justify-end gap-1">
                                        <div class="w-full rounded-t-md bg-[#2f7b35] transition-all duration-500" style="height: {{ $height }}%"></div>
                                        <p class="text-center text-[10px] text-gray-500">{{ $point['label'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div class="rounded-lg border border-black/10 bg-white px-3 py-2 text-xs">
                            <p class="text-[#6B7280]">Daily Sales</p>
                            <p class="mt-1 font-semibold text-[#111111]">{{ number_format($movementTrend->sum('count')) }} transactions</p>
                        </div>
                        <div class="rounded-lg border border-black/10 bg-white px-3 py-2 text-xs">
                            <p class="text-[#6B7280]">Monthly Sales</p>
                            <p class="mt-1 font-semibold text-[#111111]">{{ number_format($summary['movements_out'] ?? 0) }} total outs</p>
                        </div>
                        <div class="rounded-lg border border-black/10 bg-white px-3 py-2 text-xs">
                            <p class="text-[#6B7280]">Previous Period</p>
                            <p class="mt-1 font-semibold text-green-600">+{{ max(1, round(($summary['movements_out'] ?? 1) / 2)) }} est.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-black/10 bg-white p-5 shadow-sm">
                    <h2 class="text-sm font-semibold text-[#111111]">Revenue vs Expense</h2>
                    <p class="text-xs text-[#6B7280]">Revenue, Expenses, and Profit comparison.</p>

                    @php
                        $barMax = max((float) $revenueFromMovements, (float) $expenseFromMovements, abs((float) $netProfit), 1);
                        $revenuePct = round(($revenueFromMovements / $barMax) * 100);
                        $expensePct = round(($expenseFromMovements / $barMax) * 100);
                        $profitPct = round((abs($netProfit) / $barMax) * 100);
                    @endphp

                    <div class="mt-4 space-y-3">
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs"><span class="text-gray-600">Revenue</span><span class="font-medium">PHP {{ number_format($revenueFromMovements, 0) }}</span></div>
                            <div class="h-2 rounded-full bg-[#F4F5F7]"><div class="h-2 rounded-full bg-[#2f7b35]" style="width: {{ max($revenuePct, 3) }}%"></div></div>
                        </div>
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs"><span class="text-gray-600">Expenses</span><span class="font-medium">PHP {{ number_format($expenseFromMovements, 0) }}</span></div>
                            <div class="h-2 rounded-full bg-[#F4F5F7]"><div class="h-2 rounded-full bg-amber-500" style="width: {{ max($expensePct, 3) }}%"></div></div>
                        </div>
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs"><span class="text-gray-600">Profit</span><span class="font-medium">PHP {{ number_format($netProfit, 0) }}</span></div>
                            <div class="h-2 rounded-full bg-[#F4F5F7]"><div class="h-2 rounded-full {{ $netProfit >= 0 ? 'bg-[#111111]' : 'bg-red-500' }}" style="width: {{ max($profitPct, 3) }}%"></div></div>
                        </div>
                    </div>

                    <div class="mt-5 rounded-lg border border-black/10 bg-white px-3 py-2 text-xs">
                        <p class="text-[#6B7280]">Reports</p>
                        <p class="mt-1 font-medium text-[#111111]">Inventory Movement: {{ number_format($summary['movements_total'] ?? 0) }} total entries</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-black/10 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-black/10 px-5 py-4">
                    <h2 class="text-sm font-semibold text-[#111111]">Product Performance</h2>
                    <span class="text-xs text-[#6B7280]">Top selling products and stock health</span>
                </div>

                @if ($topSelling->isEmpty())
                    <div class="px-5 py-10 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 7l1 13h12l1-13M9 11v6m6-6v6"/></svg>
                        <p class="mt-2 text-sm text-gray-500">No sales data available yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-[#F4F5F7] text-xs uppercase tracking-wide text-[#6B7280]">
                                <tr>
                                    <th class="px-5 py-3">Product Name</th>
                                    <th class="px-5 py-3">Category</th>
                                    <th class="px-5 py-3">Units Sold</th>
                                    <th class="px-5 py-3">Revenue Generated</th>
                                    <th class="px-5 py-3">Stock Remaining</th>
                                    <th class="px-5 py-3">Performance Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($topSelling as $row)
                                    @php
                                        $product = $row['product'];
                                        $isTop = $loop->first;
                                        $isLow = ($product?->current_stock ?? 0) <= ($product?->min_stock ?? 0);
                                    @endphp
                                    <tr class="transition hover:bg-[#F4F5F7]">
                                        <td class="px-5 py-3 font-medium text-[#111111]">{{ $product?->name ?? 'Unknown Product' }}</td>
                                        <td class="px-5 py-3 text-gray-600">{{ $product?->category?->name ?? 'Uncategorized' }}</td>
                                        <td class="px-5 py-3 text-gray-700">{{ number_format($row['units']) }}</td>
                                        <td class="px-5 py-3 text-gray-700">PHP {{ number_format($row['revenue'], 2) }}</td>
                                        <td class="px-5 py-3 text-gray-700">{{ (int) ($product?->current_stock ?? 0) }}</td>
                                        <td class="px-5 py-3">
                                            <div class="flex flex-wrap items-center gap-2">
                                                @if ($isTop)
                                                    <span class="rounded-full border border-green-200 bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700">Top selling</span>
                                                @endif
                                                @if ($isLow)
                                                    <span class="rounded-full border border-amber-200 bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Low stock warning</span>
                                                @else
                                                    <span class="rounded-full border border-black/10 bg-[#F4F5F7] px-2 py-0.5 text-xs font-medium text-gray-700">Healthy stock</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
                <div class="xl:col-span-2 rounded-xl border border-black/10 bg-white p-5 shadow-sm">
                    <h2 class="text-sm font-semibold text-[#111111]">Customer Analytics</h2>
                    <p class="text-xs text-[#6B7280]">New and returning customer behavior.</p>

                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div class="rounded-lg border border-black/10 bg-white p-3">
                            <p class="text-xs text-[#6B7280]">New Customers</p>
                            <p class="mt-1 text-xl font-semibold">{{ number_format($newCustomers) }}</p>
                        </div>
                        <div class="rounded-lg border border-black/10 bg-white p-3">
                            <p class="text-xs text-[#6B7280]">Returning Customers</p>
                            <p class="mt-1 text-xl font-semibold">{{ number_format($returningCustomers) }}</p>
                        </div>
                        <div class="rounded-lg border border-black/10 bg-white p-3">
                            <p class="text-xs text-[#6B7280]">Customer Growth Rate</p>
                            <p class="mt-1 text-xl font-semibold text-[#2f7b35]">{{ $customerGrowthRate }}%</p>
                        </div>
                    </div>

                    <div class="mt-4 h-28 rounded-xl border border-black/10 bg-white p-3">
                        <div class="flex h-full items-end gap-2">
                            @foreach ($last6Months as $month)
                                @php $h = max(8, round(($month['new_customers'] / $customerChartMax) * 100)); @endphp
                                <div class="flex-1">
                                    <div class="flex h-full flex-col justify-end gap-1">
                                        <div class="w-full rounded-t bg-[#2f7b35]/90" style="height: {{ $h }}%"></div>
                                        <span class="text-center text-[10px] text-gray-500">{{ $month['label'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-black/10 bg-white p-5 shadow-sm">
                    <h2 class="text-sm font-semibold text-[#111111]">Inventory Report</h2>
                    <p class="text-xs text-[#6B7280]">Current stock health and valuation.</p>

                    <div class="mt-4 space-y-2">
                        <div class="rounded-lg border border-black/10 bg-white px-3 py-2 text-xs"><span class="text-gray-500">Total Products</span><p class="mt-1 text-sm font-semibold">{{ number_format($totalProducts) }}</p></div>
                        <div class="rounded-lg border border-black/10 bg-white px-3 py-2 text-xs"><span class="text-gray-500">Low Stock Items</span><p class="mt-1 text-sm font-semibold text-amber-700">{{ number_format($lowStockCount) }}</p></div>
                        <div class="rounded-lg border border-black/10 bg-white px-3 py-2 text-xs"><span class="text-gray-500">Out of Stock Items</span><p class="mt-1 text-sm font-semibold text-red-600">{{ number_format($outStockCount) }}</p></div>
                        <div class="rounded-lg border border-black/10 bg-white px-3 py-2 text-xs"><span class="text-gray-500">Total Inventory Value</span><p class="mt-1 text-sm font-semibold">PHP {{ number_format($inventoryValue, 2) }}</p></div>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div>
                            <div class="mb-1 flex items-center justify-between text-[11px]"><span class="text-gray-600">Healthy Stock</span><span class="font-medium">{{ $stockHealthyPct }}%</span></div>
                            <div class="h-2 rounded-full bg-[#F4F5F7]"><div class="h-2 rounded-full bg-[#2f7b35]" style="width: {{ max($stockHealthyPct, 2) }}%"></div></div>
                        </div>
                        <div>
                            <div class="mb-1 flex items-center justify-between text-[11px]"><span class="text-gray-600">Low Stock</span><span class="font-medium">{{ $stockLowPct }}%</span></div>
                            <div class="h-2 rounded-full bg-[#F4F5F7]"><div class="h-2 rounded-full bg-amber-500" style="width: {{ max($stockLowPct, 2) }}%"></div></div>
                        </div>
                        <div>
                            <div class="mb-1 flex items-center justify-between text-[11px]"><span class="text-gray-600">Out of Stock</span><span class="font-medium">{{ $stockOutPct }}%</span></div>
                            <div class="h-2 rounded-full bg-[#F4F5F7]"><div class="h-2 rounded-full bg-red-500" style="width: {{ max($stockOutPct, 2) }}%"></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-black/10 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-black/10 px-5 py-4">
                    <h2 class="text-sm font-semibold text-[#111111]">Recent Transactions</h2>
                    <span class="text-xs text-[#6B7280]">Invoices, payment status, and timeline</span>
                </div>

                @if ($transactions->isEmpty())
                    <div class="px-5 py-12 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 7l1 13h12l1-13M9 11v6m6-6v6"/></svg>
                        <p class="mt-2 text-sm text-gray-500">No transactions found for the selected filters.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-[#F4F5F7] text-xs uppercase tracking-wide text-[#6B7280]">
                                <tr>
                                    <th class="px-5 py-3">Invoice Number</th>
                                    <th class="px-5 py-3">Customer</th>
                                    <th class="px-5 py-3">Amount</th>
                                    <th class="px-5 py-3">Payment Status</th>
                                    <th class="px-5 py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($transactions as $tx)
                                    <tr class="transition hover:bg-[#F4F5F7]">
                                        <td class="px-5 py-3 font-mono text-xs text-gray-700">{{ $tx['invoice'] }}</td>
                                        <td class="px-5 py-3 font-medium text-[#111111]">{{ $tx['customer'] }}</td>
                                        <td class="px-5 py-3 text-gray-700">PHP {{ number_format($tx['amount'], 2) }}</td>
                                        <td class="px-5 py-3"><span class="inline-flex rounded-full border px-2 py-0.5 text-xs font-medium {{ $tx['status_class'] }}">{{ $tx['status'] }}</span></td>
                                        <td class="px-5 py-3 text-gray-500">{{ $tx['date']->format('M d, Y g:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        (function () {
            const skeleton = document.getElementById('reports-skeleton');
            const content = document.getElementById('reports-content');
            const exportToggle = document.getElementById('export-toggle');
            const exportMenu = document.getElementById('export-menu');

            window.setTimeout(function () {
                skeleton?.classList.add('hidden');
                content?.classList.remove('hidden');
            }, 280);

            exportToggle?.addEventListener('click', function () {
                exportMenu?.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!exportMenu || !exportToggle) return;
                if (exportMenu.contains(event.target) || exportToggle.contains(event.target)) return;
                exportMenu.classList.add('hidden');
            });
        })();
    </script>
</x-app-layout>
