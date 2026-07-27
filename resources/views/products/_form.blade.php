@php $p = $product ?? null; @endphp

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $p?->name) }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span></label>
        <input type="text" name="sku" value="{{ old('sku', $p?->sku) }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('sku') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Barcode</label>
        @if ($p)
            <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <span class="text-sm font-mono text-gray-700">{{ $p->barcode }}</span>
                <a href="{{ route('inventory.barcode', $p) }}" target="_blank"
                    class="ml-auto text-xs text-indigo-600 hover:text-indigo-800 font-medium whitespace-nowrap">Print Label →</a>
            </div>
        @else
            <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <span class="text-sm text-gray-400 italic">Auto-generated on save</span>
            </div>
        @endif
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
        <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">— None —</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $p?->category_id) == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Cost Price <span class="text-red-500">*</span></label>
        <input type="number" name="cost_price" value="{{ old('cost_price', $p?->cost_price) }}" step="0.01" min="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('cost_price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price <span class="text-red-500">*</span></label>
        <input type="number" name="selling_price" value="{{ old('selling_price', $p?->selling_price) }}" step="0.01" min="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('selling_price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Unit <span class="text-red-500">*</span></label>
        <input type="text" name="unit" value="{{ old('unit', $p?->unit ?? 'pcs') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('unit') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
            @foreach (['active', 'inactive', 'draft', 'archived'] as $s)
                <option value="{{ $s }}" @selected(old('status', $p?->status ?? 'active') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Current Stock <span class="text-red-500">*</span></label>
        <input type="number" name="current_stock" value="{{ old('current_stock', $p?->current_stock ?? 0) }}" min="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('current_stock') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Min Stock <span class="text-red-500">*</span></label>
        <input type="number" name="min_stock" value="{{ old('min_stock', $p?->min_stock ?? 0) }}" min="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('min_stock') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Max Stock</label>
        <input type="number" name="max_stock" value="{{ old('max_stock', $p?->max_stock) }}" min="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('max_stock') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Warehouse</label>
        <input type="text" name="warehouse" value="{{ old('warehouse', $p?->warehouse) }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('warehouse') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
    <textarea name="description" rows="2"
        class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $p?->description) }}</textarea>
    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
    @if ($p?->image)
        <img src="{{ Storage::url($p->image) }}" class="w-16 h-16 rounded object-cover mb-2">
    @endif
    <input type="file" name="image" accept="image/*"
        class="w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
    @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
</div>
