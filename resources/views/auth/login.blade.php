<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-[#4CAF50]">Welcome back</p>
        <h1 class="mt-2 text-2xl font-semibold text-[#111111]">Sign in to BusinessOS</h1>
        <p class="mt-2 text-sm leading-6 text-[#6B7280]">Continue managing customers, products, suppliers, inventory, and reports from one platform.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" class="text-[#111111]" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4CAF50] focus:ring-[#4CAF50]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" class="text-[#111111]" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-[#4CAF50] focus:ring-[#4CAF50]" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#4CAF50] shadow-sm focus:ring-[#4CAF50]" name="remember">
                <span class="ms-2 text-sm text-[#6B7280]">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#4CAF50] transition hover:text-[#2f7b35]" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center rounded-full border-[#111111] bg-[#111111] text-white hover:bg-black focus:bg-black active:bg-black focus:ring-[#4CAF50]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
