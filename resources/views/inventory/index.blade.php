<x-app-layout>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $stockColors = [
            'in_stock'     => 'bg-green-50 text-green-700 border-green-200',
            'low_stock'    => 'bg-yellow-50 text-yellow-700 border-yellow-200',
            'out_of_stock' => 'bg-red-50 text-red-700 border-red-200',
        ];
        $stockLabels = [
            'in_stock'     => 'In Stock',
            'low_stock'    => 'Low Stock',
            'out_of_stock' => 'Out of Stock',
        ];
        $typeColors = [
            'in'         => 'bg-green-50 text-green-700 border-green-200',
            'out'        => 'bg-red-50 text-red-700 border-red-200',
            'adjustment' => 'bg-gray-100 text-gray-700 border-gray-200',
        ];
    @endphp

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="rounded-2xl border border-black/10 bg-white p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Products</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $totalProducts }}</p>
        </div>
        <div class="rounded-2xl border border-black/10 bg-white p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">In Stock</p>
            <p class="text-2xl font-semibold text-green-600 mt-1">{{ $inStockCount }}</p>
        </div>
        <div class="rounded-2xl border border-black/10 bg-white p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Low Stock</p>
            <p class="text-2xl font-semibold text-yellow-600 mt-1">{{ $lowStockCount }}</p>
        </div>
        <div class="rounded-2xl border border-black/10 bg-white p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Out of Stock</p>
            <p class="text-2xl font-semibold text-red-600 mt-1">{{ $outOfStockCount }}</p>
        </div>
    </div>

    {{-- Stock Overview --}}
    <div class="mb-8">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-base font-semibold text-[#111111]">Stock Overview</h2>
            <div class="flex flex-wrap gap-2 items-center">
                <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-wrap gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or SKU..."
                        class="w-full sm:w-40 rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    <select name="category" class="w-full sm:w-auto rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <select name="stock_status" class="w-full sm:w-auto rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                        <option value="">All Stock</option>
                        <option value="in_stock" @selected(request('stock_status') === 'in_stock')>In Stock</option>
                        <option value="low_stock" @selected(request('stock_status') === 'low_stock')>Low Stock</option>
                        <option value="out_of_stock" @selected(request('stock_status') === 'out_of_stock')>Out of Stock</option>
                    </select>
                    <button type="submit" class="rounded-lg border border-black/10 bg-white px-3 py-2 text-sm text-gray-700 transition hover:bg-[#F4F5F7]">Filter</button>
                    @if (request()->hasAny(['search', 'category', 'stock_status']))
                        <a href="{{ route('inventory.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                    @endif
                </form>
                <button onclick="document.getElementById('modal-adjust').classList.remove('hidden')"
                    class="inline-flex items-center gap-1 rounded-lg border border-[#111111] bg-[#111111] px-4 py-2 text-sm font-medium text-white transition hover:bg-black whitespace-nowrap">
                    + Adjust Stock
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#F4F5F7] border-b border-black/10 text-[#6B7280] uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-5 py-3">Product</th>
                            <th class="px-5 py-3">SKU</th>
                            <th class="px-5 py-3">Category</th>
                            <th class="px-5 py-3">Current Stock</th>
                            <th class="px-5 py-3">Min</th>
                            <th class="px-5 py-3">Max</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($products as $product)
                            @php $ss = $product->stockStatusLabel(); @endphp
                            <tr class="transition hover:bg-[#F4F5F7]">
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                                <td class="px-5 py-3 text-gray-400 font-mono text-xs">{{ $product->sku }}</td>
                                <td class="px-5 py-3 text-gray-500">{{ $product->category?->name ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="font-semibold {{ $ss === 'out_of_stock' ? 'text-red-600' : ($ss === 'low_stock' ? 'text-yellow-600' : 'text-gray-800') }}">
                                        {{ $product->current_stock }}
                                    </span>
                                    <span class="text-gray-400 text-xs ml-1">{{ $product->unit }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $product->min_stock }}</td>
                                <td class="px-5 py-3 text-gray-500">{{ $product->max_stock ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $stockColors[$ss] }}">
                                        {{ $stockLabels[$ss] }}
                                    </span>
                                </td>
                                                <td class="px-5 py-3 text-right">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('inventory.barcode', $product) }}" target="_blank"
                                            class="text-gray-400 hover:text-gray-600 text-sm font-medium">Label</a>
                                        <button onclick="openAdjust({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->current_stock }})"
                                            class="text-[#2f7b35] hover:text-[#1f5a25] text-sm font-medium">Adjust</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-400 py-10 text-sm">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile --}}
            <div class="sm:hidden divide-y divide-gray-100">
                @forelse ($products as $product)
                    @php $ss = $product->stockStatusLabel(); @endphp
                    <div class="px-4 py-4 flex items-center justify-between gap-2">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $product->name }}</p>
                            <p class="text-gray-400 text-xs font-mono">{{ $product->sku }}</p>
                            <p class="text-xs mt-1">
                                <span class="font-semibold {{ $ss === 'out_of_stock' ? 'text-red-600' : ($ss === 'low_stock' ? 'text-yellow-600' : 'text-gray-700') }}">
                                    {{ $product->current_stock }} {{ $product->unit }}
                                </span>
                                <span class="text-gray-400">/ min {{ $product->min_stock }}</span>
                            </p>
                        </div>
                        <div class="flex flex-col items-end gap-2 shrink-0">
                            <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $stockColors[$ss] }}">
                                {{ $stockLabels[$ss] }}
                            </span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('inventory.barcode', $product) }}" target="_blank"
                                    class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium text-gray-600">
                                    Label
                                </a>
                                <button onclick="openAdjust({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->current_stock }})"
                                    class="inline-flex items-center rounded-md border border-[#BFE7AF] bg-[#EAF8E5] px-2 py-1 text-xs font-medium text-[#2f7b35]">
                                    Adjust
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-10 text-sm">No products found.</div>
                @endforelse
            </div>
        </div>

        @if ($products->hasPages())
            <div class="mt-4">{{ $products->links() }}</div>
        @endif
    </div>

    {{-- Movement History --}}
    <div>
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-base font-semibold text-[#111111]">Movement History</h2>
            <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-wrap gap-2">
                @foreach (['search', 'category', 'stock_status'] as $f)
                    @if (request($f))
                        <input type="hidden" name="{{ $f }}" value="{{ request($f) }}">
                    @endif
                @endforeach
                <input type="text" name="ref_search" value="{{ request('ref_search') }}" placeholder="Search ref # (e.g. PO-2026-0001)"
                    class="w-full sm:w-52 rounded-lg border border-black/10 shadow-sm text-sm text-gray-900 focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                <select name="movement_type" class="w-full sm:w-auto rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    <option value="">All Types</option>
                    <option value="in" @selected(request('movement_type') === 'in')>Stock In</option>
                    <option value="out" @selected(request('movement_type') === 'out')>Stock Out</option>
                    <option value="adjustment" @selected(request('movement_type') === 'adjustment')>Adjustment</option>
                </select>
                <button type="submit" class="rounded-lg border border-black/10 bg-white px-3 py-2 text-sm text-gray-700 transition hover:bg-[#F4F5F7]">Filter</button>
                @if (request()->hasAny(['ref_search', 'movement_type']))
                    <a href="{{ route('inventory.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                @endif
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#F4F5F7] border-b border-black/10 text-[#6B7280] uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-5 py-3">Date</th>
                            <th class="px-5 py-3">Product</th>
                            <th class="px-5 py-3">Type</th>
                            <th class="px-5 py-3">Qty Change</th>
                            <th class="px-5 py-3">Before → After</th>
                            <th class="px-5 py-3">Reason</th>
                            <th class="px-5 py-3">Reference</th>
                            <th class="px-5 py-3">By</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($movements as $m)
                            @php $movementReference = $m->reference_number ?? $m->reference; @endphp
                            <tr class="transition hover:bg-[#F4F5F7] align-top">
                                <td class="px-5 py-3 text-gray-400 text-xs whitespace-nowrap">{{ $m->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-5 py-3 min-w-[220px]">
                                    <div class="font-medium text-gray-800 break-words">{{ $m->product?->name ?? 'Deleted product' }}</div>
                                    @if ($m->product?->sku)
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $m->product->sku }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $typeColors[$m->type] }}">
                                        {{ ucfirst($m->type) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 font-semibold {{ $m->quantity >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $m->quantity >= 0 ? '+' : '' }}{{ $m->quantity }}
                                </td>
                                <td class="px-5 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $m->stock_before }} → {{ $m->stock_after }}</td>
                                <td class="px-5 py-3 text-gray-500 max-w-[220px] break-words">{{ $m->reason ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    @if (!empty($movementReference))
                                        <span class="inline-flex font-mono text-xs px-2.5 py-1 rounded-full border
                                            {{ str_starts_with($movementReference, 'PO') ? 'bg-green-50 text-green-700 border-green-200' : (str_starts_with($movementReference, 'INV') ? 'bg-red-50 text-red-700 border-red-200' : 'bg-gray-100 text-gray-700 border-gray-200') }}">
                                            {{ $movementReference }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $m->user?->name ?? 'System' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-400 py-10 text-sm">No movements recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile --}}
            <div class="sm:hidden divide-y divide-gray-100">
                @forelse ($movements as $m)
                    @php $movementReference = $m->reference_number ?? $m->reference; @endphp
                    <div class="px-4 py-4">
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-800 text-sm break-words">{{ $m->product?->name ?? 'Deleted product' }}</p>
                                    @if ($m->product?->sku)
                                        <p class="text-gray-400 text-xs font-mono mt-0.5">{{ $m->product->sku }}</p>
                                    @endif
                                    <p class="text-gray-400 text-xs mt-2">{{ $m->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full shrink-0 {{ $typeColors[$m->type] }}">
                                    {{ ucfirst($m->type) }}
                                </span>
                            </div>

                            <div class="mt-3 flex items-center justify-between gap-2">
                                <div>
                                    <p class="text-sm font-semibold {{ $m->quantity >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $m->quantity >= 0 ? '+' : '' }}{{ $m->quantity }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $m->stock_before }} → {{ $m->stock_after }}</p>
                                </div>
                                @if (!empty($movementReference))
                                    <span class="inline-flex font-mono text-[11px] px-2 py-1 rounded-full border {{ str_starts_with($movementReference, 'PO') ? 'bg-green-50 text-green-700 border-green-200' : (str_starts_with($movementReference, 'INV') ? 'bg-red-50 text-red-700 border-red-200' : 'bg-gray-100 text-gray-700 border-gray-200') }}">
                                        {{ $movementReference }}
                                    </span>
                                @endif
                            </div>

                            @if ($m->reason)
                                <p class="mt-2 text-xs text-gray-500">{{ $m->reason }}</p>
                            @endif

                            <div class="mt-3 flex items-center justify-between border-t border-gray-200 pt-2 text-xs text-gray-400">
                                <span>{{ $m->user?->name ?? 'System' }}</span>
                                <span>Reference</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-10 text-sm">No movements recorded yet.</div>
                @endforelse
            </div>
        </div>

        @if ($movements->hasPages())
            <div class="mt-4">{{ $movements->appends(request()->except('mpage'))->links() }}</div>
        @endif
    </div>

    {{-- Adjust Stock Modal --}}
    <div id="modal-adjust" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Adjust Stock</h2>
                <button onclick="closeAdjust()" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product <span class="text-red-500">*</span></label>
                    <select name="product_id" id="adj-product" onchange="updateCurrentStock()"
                        class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                        <option value="">— Select Product —</option>
                        @foreach ($allProducts as $p)
                            <option value="{{ $p->id }}" data-stock="{{ $p->current_stock }}" data-unit="{{ $p->unit }}">
                                {{ $p->name }} ({{ $p->sku }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="adj-current-stock" class="hidden text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                    Current stock: <span id="adj-stock-val" class="font-semibold text-gray-800"></span> <span id="adj-unit-val"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach (['in' => 'Stock In', 'out' => 'Stock Out', 'adjustment' => 'Adjustment'] as $val => $label)
                            <label class="flex items-center justify-center gap-1.5 border rounded-lg px-3 py-2 cursor-pointer text-sm has-[:checked]:border-[#4CAF50] has-[:checked]:bg-[#EAF8E5] has-[:checked]:text-[#2f7b35] text-gray-600 hover:bg-gray-50 transition">
                                <input type="radio" name="type" value="{{ $val }}" class="sr-only" @checked(old('type', 'in') === $val)>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                    @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" min="1"
                        class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    <p class="text-xs text-gray-400 mt-1">For <em>Adjustment</em>, enter the new absolute stock value.</p>
                    @error('quantity') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference #</label>
                    <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        <span class="text-sm text-gray-400 italic" id="adj-ref-preview">Auto-generated on save</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                    <input type="text" name="reason" value="{{ old('reason') }}" placeholder="e.g. Purchase delivery, Damaged goods..."
                        class="w-full rounded-lg border border-black/10 shadow-sm text-sm text-gray-900 focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    @error('reason') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" onclick="closeAdjust()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                    <button type="submit" class="rounded-lg border border-[#111111] bg-[#111111] px-5 py-2 text-sm font-medium text-white transition hover:bg-black">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAdjust(productId, productName, currentStock) {
            const modal = document.getElementById('modal-adjust');
            const select = document.getElementById('adj-product');
            select.value = productId;
            updateCurrentStock();
            updateRefPreview();
            modal.classList.remove('hidden');
        }

        function closeAdjust() {
            document.getElementById('modal-adjust').classList.add('hidden');
        }

        function updateCurrentStock() {
            const select = document.getElementById('adj-product');
            const opt = select.options[select.selectedIndex];
            const box = document.getElementById('adj-current-stock');
            if (opt && opt.dataset.stock !== undefined) {
                document.getElementById('adj-stock-val').textContent = opt.dataset.stock;
                document.getElementById('adj-unit-val').textContent = opt.dataset.unit;
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        }

        function updateRefPreview() {
            const type = document.querySelector('input[name="type"]:checked')?.value || 'in';
            const prefixes = { in: 'PO', out: 'INV', adjustment: 'ADJ' };
            const year = new Date().getFullYear();
            document.getElementById('adj-ref-preview').textContent =
                (prefixes[type] || 'REF') + '-' + year + '-XXXX (auto)';
        }

        document.querySelectorAll('input[name="type"]').forEach(r => r.addEventListener('change', updateRefPreview));

        document.addEventListener('DOMContentLoaded', function () {
            updateRefPreview();
            @if ($errors->any())
                document.getElementById('modal-adjust').classList.remove('hidden');
            @endif
        });
    </script>
</x-app-layout>
