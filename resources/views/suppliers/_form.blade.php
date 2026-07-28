<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
        <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person ?? '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('contact_person') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $supplier->phone ?? '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tax ID</label>
        <input type="text" name="tax_id" value="{{ old('tax_id', $supplier->tax_id ?? '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
        @error('tax_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="is_active" class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="1" @selected(old('is_active', $supplier->is_active ?? true))>Active</option>
            <option value="0" @selected(!old('is_active', $supplier->is_active ?? true))>Inactive</option>
        </select>
        @error('is_active') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
        <textarea name="address" rows="3"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $supplier->address ?? '') }}</textarea>
        @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>
