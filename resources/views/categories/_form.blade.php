@php $c = $category ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $c?->name) }}"
        class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
    <textarea name="description" rows="2"
        class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">{{ old('description', $c?->description) }}</textarea>
    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div class="flex items-center gap-2">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active_{{ $c?->id ?? 'new' }}" value="1"
        @checked(old('is_active', $c?->is_active ?? true))
        class="rounded border-black/20 text-[#2f7b35] focus:ring-[#4CAF50]">
    <label for="is_active_{{ $c?->id ?? 'new' }}" class="text-sm text-gray-700">Active</label>
</div>
