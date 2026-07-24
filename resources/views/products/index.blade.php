<x-app-layout>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

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

                <select name="category" class="border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="status" class="border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                </select>

                <select name="stock_status" class="border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
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

            <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
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
                                @php $stockLabel = $product->stockStatusLabel(); @endphp
                                <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full border
                                    {{ $stockLabel === 'in_stock' ? 'bg-green-50 text-green-700 border-green-200' : ($stockLabel === 'low_stock' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 'bg-red-50 text-red-700 border-red-200') }}">
                                    {{ $product->current_stock }} {{ $product->unit }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                @php
                                    $statusColors = [
                                        'active'   => 'bg-green-50 text-green-700 border-green-200',
                                        'inactive' => 'bg-gray-100 text-gray-500 border-gray-200',
                                        'draft'    => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'archived' => 'bg-orange-50 text-orange-600 border-orange-200',
                                    ];
                                @endphp
                                <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $statusColors[$product->status] ?? '' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <button onclick="openEdit({{ $product->id }})"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</button>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('Delete this product?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                                    </form>
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
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $product->name }}</p>
                            <p class="text-gray-400 text-xs font-mono mt-0.5">{{ $product->sku }}</p>
                            <p class="text-gray-600 text-xs mt-0.5">₱{{ number_format($product->selling_price, 2) }} · {{ $product->current_stock }} {{ $product->unit }}</p>
                        </div>
                        <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $statusColors[$product->status] ?? '' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                    <div class="flex gap-4 mt-3">
                        <button onclick="openEdit({{ $product->id }})" class="text-indigo-600 text-sm font-medium">Edit</button>
                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                            onsubmit="return confirm('Delete this product?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm font-medium">Delete</button>
                        </form>
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
                <button onclick="document.getElementById('modal-create').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
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

    {{-- Edit Modals --}}
    @foreach ($products as $product)
        <div id="modal-edit-{{ $product->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Edit Product</h2>
                    <button onclick="document.getElementById('modal-edit-{{ $product->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
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

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('modal-create').classList.remove('hidden');
            });
        </script>
    @endif

    <script>
        function openEdit(id) {
            document.getElementById('modal-edit-' + id).classList.remove('hidden');
        }
    </script>
</x-app-layout>
