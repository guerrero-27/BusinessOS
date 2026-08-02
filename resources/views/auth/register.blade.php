<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Create account</p>
        <h1 class="mt-2 text-2xl font-semibold text-slate-900">Start with BusinessOS</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">Set up your workspace and begin managing customers and inventory with confidence.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" class="text-slate-700" :value="__('Name')" />
            <x-text-input id="name" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" class="text-slate-700" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" class="text-slate-700" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" class="text-slate-700" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-medium text-slate-600 transition hover:text-sky-700" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="rounded-full border-lime-300 bg-lime-300 text-slate-900 hover:bg-lime-200 focus:bg-lime-200 active:bg-lime-300 focus:ring-lime-300">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
