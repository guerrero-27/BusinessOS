<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BusinessOS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white font-sans text-slate-900 antialiased">
        <div class="flex min-h-screen flex-col lg:flex-row">
            {{-- Brand panel --}}
            <div class="relative hidden overflow-hidden bg-gradient-to-b from-sky-700 via-sky-500 to-sky-300 px-10 py-12 text-white lg:flex lg:w-2/5 lg:flex-col lg:justify-between xl:w-1/3">
                <a href="/" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/15 backdrop-blur">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-white" fill="currentColor">
                            <path d="M12 2 L22 20 L12 15 L2 20 Z" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold">{{ config('app.name', 'BusinessOS') }}</span>
                </a>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-100">Business made simple</p>
                    <h2 class="mt-4 text-3xl font-semibold leading-tight">Run your operations from one clean workspace.</h2>
                    <p class="mt-4 max-w-sm text-sm leading-6 text-sky-50/90">Customer records, inventory levels, and product details organized and always in sync.</p>

                    <ul class="mt-8 space-y-3 text-sm">
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-lime-300 text-slate-900">✓</span>
                            Centralized customer management
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-lime-300 text-slate-900">✓</span>
                            Real-time inventory tracking
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-lime-300 text-slate-900">✓</span>
                            Reports built for daily decisions
                        </li>
                    </ul>
                </div>

                <p class="text-xs text-sky-100/80">&copy; {{ now()->year }} {{ config('app.name', 'BusinessOS') }}</p>
            </div>

            {{-- Form panel --}}
            <div class="flex flex-1 flex-col">
                <div class="flex items-center justify-between px-4 py-5 sm:px-6 lg:justify-end lg:px-10">
                    <a href="/" class="flex items-center gap-2 lg:hidden">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-600 text-white">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                                <path d="M12 2 L22 20 L12 15 L2 20 Z" />
                            </svg>
                        </span>
                        <span class="text-sm font-semibold text-slate-900">{{ config('app.name', 'BusinessOS') }}</span>
                    </a>
                    <a href="/" class="text-sm font-medium text-slate-500 transition hover:text-sky-600">
                        Back home
                    </a>
                </div>

                <div class="flex flex-1 items-center justify-center bg-slate-50/70 px-4 pb-12 pt-2 sm:px-6">
                    <div class="w-full max-w-md overflow-hidden rounded-[2rem] border border-sky-100 bg-white p-6 shadow-2xl shadow-sky-100/80 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
