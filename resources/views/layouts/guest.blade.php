<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BusinessOS') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F4F5F7] font-sans text-[#111111] antialiased">
        <div class="flex min-h-screen flex-col lg:flex-row">
            {{-- Brand panel --}}
            <div class="relative hidden overflow-hidden bg-[#111111] px-10 py-12 text-white lg:flex lg:w-2/5 lg:flex-col lg:justify-between xl:w-1/3">
                <span class="pointer-events-none absolute -right-16 -top-16 h-52 w-52 rounded-full bg-[#7ED957]/15 blur-2xl"></span>
                <span class="pointer-events-none absolute -left-12 bottom-14 h-44 w-44 rounded-full bg-[#4CAF50]/20 blur-2xl"></span>

                <a href="/" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7ED957] to-[#4CAF50] text-[#111111]">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
                            <path d="M12 2 L22 20 L12 15 L2 20 Z" />
                        </svg>
                    </span>
                    <div>
                        <span class="text-base font-semibold">BusinessOS</span>
                        <p class="text-xs text-white/65">{{ config('app.name', 'BusinessOS') }} Platform</p>
                    </div>
                </a>

                <div class="relative z-10">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-[#7ED957]">Operations made simple</p>
                    <h2 class="mt-4 text-3xl font-semibold leading-tight">Access BusinessOS from your secure workspace.</h2>
                    <p class="mt-4 max-w-sm text-sm leading-6 text-white/80">Sign in to manage customers, products, suppliers, and inventory movements with complete reporting visibility.</p>

                    <ul class="mt-8 space-y-3 text-sm">
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#7ED957] text-[#111111]">✓</span>
                            Verified access for dashboard and reports
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#7ED957] text-[#111111]">✓</span>
                            Reference-based inventory movement history
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#7ED957] text-[#111111]">✓</span>
                            Customer, product, and supplier modules
                        </li>
                    </ul>
                </div>

                <p class="text-xs text-white/65">&copy; {{ now()->year }} {{ config('app.name', 'BusinessOS') }}</p>
            </div>

            {{-- Form panel --}}
            <div class="flex flex-1 flex-col">
                <div class="flex items-center justify-between px-4 py-5 sm:px-6 lg:justify-end lg:px-10">
                    <a href="/" class="flex items-center gap-2 lg:hidden">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-[#7ED957] to-[#4CAF50] text-[#111111]">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                                <path d="M12 2 L22 20 L12 15 L2 20 Z" />
                            </svg>
                        </span>
                        <span class="text-sm font-semibold text-[#111111]">BusinessOS</span>
                    </a>
                    <a href="/" class="text-sm font-medium text-[#6B7280] transition hover:text-[#111111]">
                        Back home
                    </a>
                </div>

                <div class="flex flex-1 items-center justify-center px-4 pb-12 pt-2 sm:px-6">
                    <div class="w-full max-w-md overflow-hidden rounded-[2rem] border border-black/10 bg-white p-6 shadow-2xl shadow-black/5 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
