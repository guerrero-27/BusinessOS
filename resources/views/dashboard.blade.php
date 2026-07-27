<x-app-layout>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Welcome back, {{ auth()->user()->name }} 👋</h1>
            <p class="text-sm text-gray-400 mt-0.5">
                {{ now()->format('l, F j, Y') }}
                &nbsp;·&nbsp;
                Last login: {{ now()->format('g:i A') }}
            </p>
        </div>
        {{-- Quick Actions --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('customers.create') }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition">
                + Add Customer
            </a>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-50 transition">
                + Add Product
            </a>
            <a href="{{ route('inventory.index') }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-50 transition">
                Adjust Stock
            </a>
        </div>
    </div>

    {{-- KPI Row 1: Customers --}}
    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Customers</p>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total Customers</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $customerStats['total'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Active</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $customerStats['active'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Inactive</p>
            <p class="text-2xl font-bold text-gray-400 mt-1">{{ $customerStats['inactive'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">New This Month</p>
            <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $customerStats['new'] }}</p>
        </div>
    </div>

    {{-- KPI Row 2: Inventory --}}
    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Inventory</p>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total Products</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $inventoryStats['total'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Low Stock</p>
            <p class="text-2xl font-bold text-yellow-500 mt-1">{{ $inventoryStats['low_stock'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Out of Stock</p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $inventoryStats['out_of_stock'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Categories</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Category::where('is_active', true)->count() }}</p>
        </div>
    </div>

    {{-- KPI Row 3: Finance --}}
    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Finance</p>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Today's Sales</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">—</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Monthly Revenue</p>
            <p class="text-2xl font-bold text-green-600 mt-1">—</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Expenses</p>
            <p class="text-2xl font-bold text-red-500 mt-1">—</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Net Profit</p>
            <p class="text-2xl font-bold text-indigo-600 mt-1">—</p>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
        {{-- Customer Growth --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-700 mb-4">Customer Growth</p>
            <div class="h-40 flex items-end gap-2">
                @php
                    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul'];
                    $values = [4, 7, 5, 10, 8, 13, $customerStats['total']];
                    $max = max($values) ?: 1;
                @endphp
                @foreach ($months as $i => $month)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-indigo-500 rounded-t" style="height: {{ round(($values[$i] / $max) * 100) }}%"></div>
                        <span class="text-xs text-gray-400">{{ $month }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Sales vs Expenses --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-700 mb-4">Sales vs Expenses</p>
            <div class="h-40 flex items-end gap-3">
                @php
                    $salesData    = [12, 19, 14, 22, 18, 25, 20];
                    $expenseData  = [8, 11, 9, 14, 12, 16, 13];
                    $barMax = max(array_merge($salesData, $expenseData)) ?: 1;
                @endphp
                @foreach ($months as $i => $month)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full flex items-end gap-0.5" style="height: 100%;">
                            <div class="flex-1 bg-indigo-400 rounded-t" style="height: {{ round(($salesData[$i] / $barMax) * 100) }}%"></div>
                            <div class="flex-1 bg-red-300 rounded-t" style="height: {{ round(($expenseData[$i] / $barMax) * 100) }}%"></div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $month }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex gap-4 mt-3">
                <span class="flex items-center gap-1 text-xs text-gray-500"><span class="w-2.5 h-2.5 rounded-sm bg-indigo-400 inline-block"></span> Sales</span>
                <span class="flex items-center gap-1 text-xs text-gray-500"><span class="w-2.5 h-2.5 rounded-sm bg-red-300 inline-block"></span> Expenses</span>
            </div>
        </div>

        {{-- Monthly Revenue --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-700 mb-4">Monthly Revenue</p>
            <div class="relative h-40">
                @php
                    $revenuePoints = [30, 45, 35, 60, 50, 70, 55];
                    $rMax = max($revenuePoints) ?: 1;
                    $rCount = count($revenuePoints);
                    $svgPoints = collect($revenuePoints)->map(function($v, $i) use ($rMax, $rCount) {
                        $x = ($i / ($rCount - 1)) * 100;
                        $y = 100 - round(($v / $rMax) * 90);
                        return "{$x},{$y}";
                    })->join(' ');
                    $areaPoints = "0,100 " . $svgPoints . " 100,100";
                @endphp
                <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full">
                    <polygon points="{{ $areaPoints }}" fill="#e0e7ff" />
                    <polyline points="{{ $svgPoints }}" fill="none" stroke="#6366f1" stroke-width="2" vector-effect="non-scaling-stroke"/>
                </svg>
                <div class="absolute bottom-0 left-0 right-0 flex justify-between px-1">
                    @foreach ($months as $month)
                        <span class="text-xs text-gray-400">{{ $month }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Inventory Distribution --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-700 mb-4">Inventory Distribution</p>
            <div class="flex items-center gap-6">
                <svg viewBox="0 0 36 36" class="w-32 h-32 shrink-0">
                    {{-- Pie segments using stroke-dasharray trick --}}
                    <circle cx="18" cy="18" r="15.9" fill="transparent" stroke="#6366f1" stroke-width="3.8" stroke-dasharray="40 60" stroke-dashoffset="25"/>
                    <circle cx="18" cy="18" r="15.9" fill="transparent" stroke="#f59e0b" stroke-width="3.8" stroke-dasharray="25 75" stroke-dashoffset="-15"/>
                    <circle cx="18" cy="18" r="15.9" fill="transparent" stroke="#ef4444" stroke-width="3.8" stroke-dasharray="20 80" stroke-dashoffset="-40"/>
                    <circle cx="18" cy="18" r="15.9" fill="transparent" stroke="#d1d5db" stroke-width="3.8" stroke-dasharray="15 85" stroke-dashoffset="-60"/>
                </svg>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-indigo-500 inline-block"></span><span class="text-gray-600">Electronics <span class="text-gray-400">40%</span></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-yellow-400 inline-block"></span><span class="text-gray-600">Accessories <span class="text-gray-400">25%</span></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-red-400 inline-block"></span><span class="text-gray-600">Peripherals <span class="text-gray-400">20%</span></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-gray-300 inline-block"></span><span class="text-gray-600">Others <span class="text-gray-400">15%</span></span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mb-8">

        {{-- Recent Customers --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-700">Recent Customers</p>
                <a href="{{ route('customers.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">View all →</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($recentCustomers as $customer)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                            <p class="text-xs text-gray-400">{{ $customer->email }}</p>
                        </div>
                        @if ($customer->is_active)
                            <span class="text-xs bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">Active</span>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-400 border border-gray-200 px-2 py-0.5 rounded-full">Inactive</span>
                        @endif
                    </div>
                @empty
                    <div class="px-5 py-6 text-center text-sm text-gray-400">
                        No customers yet. <a href="{{ route('customers.create') }}" class="text-indigo-600 hover:underline">Add one</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Low Stock Products --}}
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
                        <span class="text-xs font-medium {{ $product->current_stock <= 0 ? 'text-red-600 bg-red-50 border-red-200' : 'text-yellow-600 bg-yellow-50 border-yellow-200' }} border px-2 py-0.5 rounded-full">
                            {{ $product->current_stock }} left
                        </span>
                    </div>
                @empty
                    <div class="px-5 py-6 text-center text-sm text-gray-400">All products are well-stocked.</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-700">Recent Activities</p>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $activities = [
                        ['user' => 'Kevin', 'action' => 'created',  'target' => 'Customer',  'time' => '2m ago'],
                        ['user' => 'John',  'action' => 'updated',  'target' => 'Product',   'time' => '15m ago'],
                        ['user' => 'Maria', 'action' => 'deleted',  'target' => 'Supplier',  'time' => '1h ago'],
                        ['user' => 'Kevin', 'action' => 'created',  'target' => 'Invoice',   'time' => '3h ago'],
                        ['user' => 'John',  'action' => 'approved', 'target' => 'Purchase Order', 'time' => '5h ago'],
                    ];
                @endphp
                @foreach ($activities as $activity)
                    <div class="px-5 py-3 flex items-start gap-3">
                        <span class="mt-0.5 w-4 h-4 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs shrink-0">✓</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">{{ $activity['user'] }}</span>
                                {{ $activity['action'] }}
                                <span class="text-gray-500">{{ $activity['target'] }}</span>
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 shrink-0">{{ $activity['time'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Upcoming Tasks --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-700">Upcoming Tasks</p>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $tasks = [
                        ['title' => 'Purchase Order Due',  'date' => 'Jul 25', 'color' => 'text-red-500'],
                        ['title' => 'Supplier Payment',    'date' => 'Jul 27', 'color' => 'text-yellow-500'],
                        ['title' => 'Inventory Check',     'date' => 'Jul 30', 'color' => 'text-indigo-500'],
                    ];
                @endphp
                @foreach ($tasks as $task)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full {{ str_replace('text-', 'bg-', $task['color']) }} shrink-0"></span>
                            <p class="text-sm text-gray-700">{{ $task['title'] }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $task['date'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Calendar / Today's Events --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-700">Today's Events</p>
                <span class="text-xs text-gray-400">{{ now()->format('M j, Y') }}</span>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $events = [
                        ['time' => '9:00 AM',  'title' => 'Team Meeting',       'type' => 'Meeting'],
                        ['time' => '11:30 AM', 'title' => 'Supplier Call',      'type' => 'Meeting'],
                        ['time' => '2:00 PM',  'title' => 'Stock Delivery',     'type' => 'Delivery'],
                        ['time' => '4:00 PM',  'title' => 'Inventory Audit',    'type' => 'Task'],
                    ];
                @endphp
                @foreach ($events as $event)
                    <div class="px-5 py-3 flex items-center gap-3">
                        <span class="text-xs text-gray-400 w-16 shrink-0">{{ $event['time'] }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700 truncate">{{ $event['title'] }}</p>
                        </div>
                        <span class="text-xs text-indigo-500 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-full shrink-0">{{ $event['type'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- System Overview --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-700">System Overview</p>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="px-5 py-3 flex items-center justify-between">
                    <p class="text-sm text-gray-600">Server Status</p>
                    <span class="text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">Online</span>
                </div>
                <div class="px-5 py-3 flex items-center justify-between">
                    <p class="text-sm text-gray-600">Database Status</p>
                    <span class="text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">Connected</span>
                </div>
                <div class="px-5 py-3 flex items-center justify-between">
                    <p class="text-sm text-gray-600">Storage Used</p>
                    <div class="flex items-center gap-2">
                        <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: 42%"></div>
                        </div>
                        <span class="text-xs text-gray-400">42%</span>
                    </div>
                </div>
                <div class="px-5 py-3 flex items-center justify-between">
                    <p class="text-sm text-gray-600">App Version</p>
                    <span class="text-xs text-gray-400">v1.0.0</span>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
