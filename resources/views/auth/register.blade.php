<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-[#4CAF50]">Create account</p>
        <h1 class="mt-2 text-2xl font-semibold text-[#111111]">Start with BusinessOS</h1>
        <p class="mt-2 text-sm leading-6 text-[#6B7280]">Create your workspace access and manage customers, stock movement, suppliers, and reports securely.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" class="text-[#111111]" :value="__('Name')" />
            <x-text-input id="name" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4CAF50] focus:ring-[#4CAF50]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" class="text-[#111111]" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4CAF50] focus:ring-[#4CAF50]" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" class="text-[#111111]" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4CAF50] focus:ring-[#4CAF50]" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" class="text-[#111111]" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4CAF50] focus:ring-[#4CAF50]" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-medium text-[#6B7280] transition hover:text-[#2f7b35]" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="rounded-full border-[#111111] bg-[#111111] text-white hover:bg-black focus:bg-black active:bg-black focus:ring-[#4CAF50]">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
