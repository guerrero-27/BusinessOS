<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('customers.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-semibold text-[#111111]">Edit Customer</h1>
        </div>

        <form action="{{ route('customers.update', $customer) }}" method="POST" class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}"
                           class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    @error('first_name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}"
                           class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    @error('last_name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                       class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                       class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="2"
                          class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Birth Date</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $customer->birth_date?->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                    @error('birth_date')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender"
                            class="w-full rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                        <option value="">— Select —</option>
                        <option value="male" @selected(old('gender', $customer->gender) === 'male')>Male</option>
                        <option value="female" @selected(old('gender', $customer->gender) === 'female')>Female</option>
                        <option value="other" @selected(old('gender', $customer->gender) === 'other')>Other</option>
                    </select>
                    @error('gender')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                       {{ old('is_active', $customer->is_active) ? 'checked' : '' }}
                       class="rounded border-black/20 text-[#2f7b35] focus:ring-[#4CAF50]">
                <label for="is_active" class="text-sm text-gray-700">Active Customer</label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('customers.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</a>
                <button type="submit" class="rounded-lg border border-[#111111] bg-[#111111] px-5 py-2 text-sm font-medium text-white transition hover:bg-black">
                    Update Customer
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
