<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Welcome back</p>
        <h1 class="mt-2 text-2xl font-semibold text-slate-900">Sign in to BusinessOS</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">Access your customer, inventory, and product workspace in seconds.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" class="text-slate-700" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" class="text-slate-700" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-sky-600 transition hover:text-sky-700" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center rounded-full border-lime-300 bg-lime-300 text-slate-900 hover:bg-lime-200 focus:bg-lime-200 active:bg-lime-300 focus:ring-lime-300">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
