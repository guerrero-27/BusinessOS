@php $c = $category ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $c?->name) }}"
        class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
    <textarea name="description" rows="2"
        class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $c?->description) }}</textarea>
    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div class="flex items-center gap-2">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active_{{ $c?->id ?? 'new' }}" value="1"
        @checked(old('is_active', $c?->is_active ?? true))
        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
    <label for="is_active_{{ $c?->id ?? 'new' }}" class="text-sm text-gray-700">Active</label>
</div>
