<x-app-layout>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $statusColors = [
            'active'   => 'bg-green-50 text-green-700 border-green-200',
            'inactive' => 'bg-gray-100 text-gray-500 border-gray-200',
            'draft'    => 'bg-blue-50 text-blue-600 border-blue-200',
            'archived' => 'bg-orange-50 text-orange-600 border-orange-200',
        ];
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
    @endphp

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Active</p>
            <p class="text-2xl font-semibold text-green-600 mt-1">{{ $activeProducts }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Low Stock</p>
            <p class="text-2xl font-semibold text-yellow-600 mt-1">{{ $lowStockProducts }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Out of Stock</p>
            <p class="text-2xl font-semibold text-red-600 mt-1">{{ $outOfStock }}</p>
        </div>
    </div>

    {{-- Header & Filters --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Products</h1>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center flex-wrap">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, SKU, barcode..."
                    class="w-full sm:w-48 border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">

                <select name="category" class="w-full sm:w-auto border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="status" class="w-full sm:w-auto border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Status</option>
                    @foreach (['active', 'inactive', 'draft', 'archived'] as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>

                <select name="stock_status" class="w-full sm:w-auto border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Stock</option>
                    <option value="in_stock" @selected(request('stock_status') === 'in_stock')>In Stock</option>
                    <option value="low_stock" @selected(request('stock_status') === 'low_stock')>Low Stock</option>
                    <option value="out_of_stock" @selected(request('stock_status') === 'out_of_stock')>Out of Stock</option>
                </select>

                <button type="submit" class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-200 transition">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'category', 'status', 'stock_status']))
                    <a href="{{ route('products.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 transition">Clear</a>
                @endif
            </form>

            <button onclick="openCreate()"
                class="inline-flex items-center justify-center gap-1 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition whitespace-nowrap">
                + Add Product
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Product</th>
                        <th class="px-5 py-3">SKU</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Price</th>
                        <th class="px-5 py-3">Stock</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($products as $product)
                        @php $stockStatus = $product->stockStatusLabel(); @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">
                                @if ($product->image)
                                    <div class="flex items-center gap-2">
                                        <img src="{{ Storage::url($product->image) }}" class="w-8 h-8 rounded object-cover">
                                        {{ $product->name }}
                                    </div>
                                @else
                                    {{ $product->name }}
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $product->sku }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-800">₱{{ number_format($product->selling_price, 2) }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full border {{ $stockColors[$stockStatus] }}">
                                    {{ $product->current_stock }} {{ $product->unit }}
                                    <span class="opacity-60">· {{ $stockLabels[$stockStatus] }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $statusColors[$product->status] ?? '' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <button onclick="openEdit({{ $product->id }})"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</button>
                                    <button onclick="openDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-400 py-10 text-sm">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="sm:hidden divide-y divide-gray-100">
            @forelse ($products as $product)
                @php $stockStatus = $product->stockStatusLabel(); @endphp
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2">
                            @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}" class="w-10 h-10 rounded object-cover shrink-0">
                            @endif
                            <div>
                                <p class="font-medium text-gray-800 text-sm">{{ $product->name }}</p>
                                <p class="text-gray-400 text-xs font-mono mt-0.5">{{ $product->sku }}</p>
                                <p class="text-gray-600 text-xs mt-0.5">₱{{ number_format($product->selling_price, 2) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1 shrink-0">
                            <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $statusColors[$product->status] ?? '' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $stockColors[$stockStatus] }}">
                                {{ $product->current_stock }} {{ $product->unit }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-3">
                        <button onclick="openEdit({{ $product->id }})" class="text-indigo-600 text-sm font-medium">Edit</button>
                        <button onclick="openDelete({{ $product->id }}, '{{ addslashes($product->name) }}')" class="text-red-500 text-sm font-medium">Delete</button>
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

    {{-- Create Modal --}}
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Add Product</h2>
                <button onclick="document.getElementById('modal-create').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @include('products._form')
                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Confirm Modal --}}
    <div id="modal-delete" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800 text-center">Delete Product</h3>
                <p class="text-sm text-gray-500 text-center mt-1">
                    Are you sure you want to delete <span id="delete-product-name" class="font-medium text-gray-800"></span>? This action cannot be undone.
                </p>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button onclick="closeDelete()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Cancel</button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition">Delete</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modals --}}
    @foreach ($products as $product)
        <div id="modal-edit-{{ $product->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Edit: {{ $product->name }}</h2>
                    <button onclick="document.getElementById('modal-edit-{{ $product->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
                </div>
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    @include('products._form', ['product' => $product])
                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <button type="button" onclick="document.getElementById('modal-edit-{{ $product->id }}').classList.add('hidden')"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        function resetCreateForm() {
            const modal = document.getElementById('modal-create');
            const form = modal?.querySelector('form');

            if (!form) return;

            form.reset();

            const blankFields = [
                ['input[name="name"]', ''],
                ['input[name="brand"]', ''],
                ['input[name="cost_price"]', ''],
                ['input[name="selling_price"]', ''],
                ['input[name="unit"]', 'pcs'],
                ['select[name="status"]', 'active'],
                ['input[name="current_stock"]', '0'],
                ['input[name="min_stock"]', '0'],
                ['input[name="max_stock"]', ''],
                ['input[name="warehouse"]', ''],
                ['textarea[name="description"]', ''],
                ['select[name="category_id"]', ''],
            ];

            blankFields.forEach(([selector, value]) => {
                const field = form.querySelector(selector);
                if (field) field.value = value;
            });

            const preview = document.getElementById('sku-preview-text-new');
            if (preview) {
                preview.textContent = 'Select category & brand to preview';
                preview.className = 'text-sm font-mono text-indigo-400 italic';
            }
        }

        function openCreate() {
            resetCreateForm();
            document.getElementById('modal-create').classList.remove('hidden');
        }

        function openDelete(id, name) {
            document.getElementById('delete-product-name').textContent = name;
            document.getElementById('delete-form').action = '/products/' + id;
            document.getElementById('modal-delete').classList.remove('hidden');
        }

        function closeDelete() {
            document.getElementById('modal-delete').classList.add('hidden');
        }

        function openEdit(id) {
            document.getElementById('modal-edit-' + id).classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->any() && session('edit_product_id'))
                openEdit({{ session('edit_product_id') }});
            @elseif ($errors->any())
                document.getElementById('modal-create').classList.remove('hidden');
            @endif
        });
    </script>
</x-app-layout>
