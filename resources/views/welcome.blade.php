<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BusinessOS') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white text-slate-900 antialiased">

        {{-- ================= NAVBAR ================= --}}
        <header class="absolute inset-x-0 top-0 z-30">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-8">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-white" fill="currentColor">
                            <path d="M12 2 L22 20 L12 15 L2 20 Z" />
                        </svg>
                    </span>
                    <span class="text-lg font-semibold text-white">BusinessOS</span>
                </a>

                {{-- Desktop links --}}
                <div class="hidden items-center gap-8 text-sm font-medium tracking-wide text-white/80 lg:flex">
                    <a href="/" class="transition hover:text-white">HOME</a>
                    <a href="#features" class="transition hover:text-white">FEATURES</a>
                    <a href="#modules" class="transition hover:text-white">MODULES</a>
                    <a href="#about" class="transition hover:text-white">ABOUT</a>
                </div>

                {{-- CTA + mobile toggle --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="hidden items-center gap-1 rounded-full bg-lime-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 transition hover:bg-lime-200 sm:inline-flex">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden text-xs font-medium uppercase tracking-wide text-white/80 transition hover:text-white sm:inline-flex">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="hidden items-center gap-1 rounded-full bg-lime-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 transition hover:bg-lime-200 sm:inline-flex">
                            Get Started
                        </a>
                    @endauth
                    <button type="button" id="menu-toggle" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/30 text-white lg:hidden" aria-label="Toggle menu" aria-expanded="false">
                        <svg id="menu-icon-open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        <svg id="menu-icon-close" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </nav>

            {{-- Mobile menu --}}
            <div id="mobile-menu" class="mx-5 mt-2 hidden rounded-2xl border border-white/10 bg-slate-900/95 p-5 text-white shadow-xl lg:hidden">
                <div class="flex flex-col gap-3 text-sm font-medium">
                    <a href="/" class="rounded-lg px-3 py-2 hover:bg-white/10">Home</a>
                    <a href="#features" class="rounded-lg px-3 py-2 hover:bg-white/10">Features</a>
                    <a href="#modules" class="rounded-lg px-3 py-2 hover:bg-white/10">Modules</a>
                    <a href="#about" class="rounded-lg px-3 py-2 hover:bg-white/10">About</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="mt-2 inline-flex justify-center rounded-full bg-lime-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 hover:bg-white/10">Log in</a>
                        <a href="{{ route('register') }}" class="mt-2 inline-flex justify-center rounded-full bg-lime-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900">Get Started</a>
                    @endauth
                </div>
            </div>
        </header>

        <script>
            (function () {
                const toggleBtn = document.getElementById('menu-toggle');
                const menu = document.getElementById('mobile-menu');
                const iconOpen = document.getElementById('menu-icon-open');
                const iconClose = document.getElementById('menu-icon-close');

                toggleBtn.addEventListener('click', function () {
                    const isHidden = menu.classList.contains('hidden');
                    menu.classList.toggle('hidden');
                    iconOpen.classList.toggle('hidden');
                    iconClose.classList.toggle('hidden');
                    toggleBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                });
            })();
        </script>

        {{-- ================= HERO ================= --}}
        <section class="relative overflow-hidden bg-gradient-to-b from-sky-700 via-sky-500 to-sky-300 pb-24 pt-32 sm:pt-40">
            <div class="mx-auto max-w-4xl px-5 text-center sm:px-8">
                <h1 class="text-3xl font-semibold leading-tight text-white sm:text-5xl md:text-6xl">
                    Run your business with
                    <span class="block text-sky-100/90">clarity and control</span>
                </h1>
                <p class="mx-auto mt-5 max-w-xl text-sm text-sky-50/90 sm:text-base">
                    BusinessOS is a Laravel-based business management system for handling authentication, customer records, and day-to-day operations from one dashboard.
                </p>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-full border border-white/30 bg-white/10 px-6 py-3 text-sm font-medium text-white backdrop-blur transition hover:bg-white/20">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/30 bg-white/10 px-6 py-3 text-sm font-medium text-white backdrop-blur transition hover:bg-white/20">
                            Log In
                        </a>
                    @endauth
                    <a href="{{ Route::has('register') ? route('register') : '#' }}" class="inline-flex items-center gap-2 rounded-full bg-lime-300 px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-lime-200">
                        Get Started
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L15.586 11H4a1 1 0 110-2h11.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>

            {{-- Fanned card stack: dashboard preview cards --}}
            <div class="relative mx-auto mt-16 hidden max-w-5xl px-5 sm:mt-20 md:flex md:items-end md:justify-center">
                <div class="w-36 -rotate-12 translate-y-6 rounded-2xl bg-white p-3 shadow-2xl lg:w-44">
                    <p class="text-[10px] font-medium text-slate-400">Total Customers</p>
                    <p class="mt-3 text-base font-semibold text-slate-900">{{ \App\Models\Customer::count() }}</p>
                    <div class="mt-3 h-16 rounded-lg bg-slate-100"></div>
                </div>
                <div class="-ml-6 w-36 -rotate-6 translate-y-2 rounded-2xl bg-white p-2 shadow-2xl lg:w-44">
                    <div class="h-28 w-full rounded-xl bg-slate-200 lg:h-32"></div>
                    <div class="mt-2 flex justify-between text-[10px] font-semibold text-slate-700">
                        <span>{{ \App\Models\Customer::where('is_active', true)->count() }} Active</span>
                        <span>{{ \App\Models\Customer::where('is_active', false)->count() }} Inactive</span>
                    </div>
                </div>
                <div class="-ml-6 w-36 rounded-2xl bg-white p-3 shadow-2xl lg:w-44">
                    <p class="text-[10px] font-medium text-slate-400">New This Month</p>
                    <div class="mt-3 h-16 rounded-lg bg-gradient-to-tr from-sky-200 to-sky-400"></div>
                </div>
                <div class="-ml-6 w-36 rotate-6 translate-y-2 rounded-2xl bg-slate-900 p-3 text-white shadow-2xl lg:w-44">
                    <p class="text-[10px] font-medium text-lime-300">Secure Auth</p>
                    <p class="mt-2 text-xs leading-snug">Login, registration, and password reset built on Laravel Breeze</p>
                </div>
                <div class="-ml-6 hidden w-32 rotate-12 translate-y-8 rounded-2xl bg-white p-3 shadow-2xl lg:flex lg:w-40">
                    <div class="flex h-full w-full flex-col items-center justify-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sky-600">+</span>
                        <p class="text-[10px] font-medium text-slate-500">Add Customer</p>
                        <p class="text-sm font-semibold text-slate-900">One click</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col items-center gap-2 px-5 text-center">
                <p class="text-xs font-medium text-sky-50/90">Built on Laravel 12 &middot; Blade &middot; Tailwind CSS &middot; MySQL</p>
            </div>
        </section>

        {{-- ================= LOGO CLOUD ================= --}}
        <section class="border-b border-slate-100 py-8">
            <div class="mx-auto flex max-w-7xl gap-10 overflow-x-auto px-5 sm:px-8">
                @foreach (['Logoipsum', 'Logoipsum', 'Logoipsum', 'Logoipsum', 'Logoipsum', 'Logoipsum'] as $logo)
                    <div class="flex shrink-0 items-center gap-2 text-slate-400">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-slate-300">
                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="8" /></svg>
                        </span>
                        <span class="text-sm font-medium">{{ $logo }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ================= ABOUT ================= --}}
        <section id="about" class="mx-auto max-w-4xl px-5 py-20 text-center sm:px-8 sm:py-28">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">• About Us</p>
            <h2 class="mt-4 text-3xl font-medium leading-snug text-slate-900 sm:text-4xl md:text-5xl">
                A global consulting partner dedicated to building
                <span class="inline-flex items-center gap-2 align-middle">
                    smarter
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-sky-500 text-white">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="8" /></svg>
                    </span>
                </span>
                <span class="mt-2 block text-slate-400">
                    and
                    <span class="inline-flex items-center gap-2 align-middle text-slate-900">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-lime-300 text-slate-900">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a6 6 0 00-3.5 10.87V15a1 1 0 001 1h5a1 1 0 001-1v-2.13A6 6 0 0010 2zM8 17a1 1 0 000 2h4a1 1 0 100-2H8z" /></svg>
                        </span>
                        more adaptive
                    </span>
                </span>
            </h2>
        </section>

        {{-- ================= STATS / BENTO GRID ================= --}}
        <section id="services" class="mx-auto max-w-7xl px-5 pb-24 sm:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                {{-- Card 1 --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-sky-600 to-sky-400 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold tracking-tight">IPSUM</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2 11h2v6H2v-6zm4-4h2v10H6V7zm4-4h2v14h-2V3zm4 7h2v7h-2v-7z" /></svg>
                        </span>
                    </div>
                    <div class="mt-24 rounded-2xl bg-white p-4 text-slate-900 sm:mt-32">
                        <p class="text-2xl font-semibold">120+</p>
                        <p class="mt-1 text-xs text-slate-500">Collaborating with leading AI and cloud technology providers.</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="rounded-3xl bg-slate-100 p-6">
                    <p class="text-xs font-medium text-slate-500">Commitment to measurable</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">100%</p>
                    <div class="mt-6 flex -space-x-2">
                        @for ($i = 0; $i < 4; $i++)
                            <span class="h-8 w-8 rounded-full border-2 border-slate-100 bg-slate-300"></span>
                        @endfor
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">
                        "Their automation strategy completely reshaped how we work. It's efficient, intelligent, and seamless."
                    </p>
                </div>

                {{-- Card 3 & 4 stacked --}}
                <div class="grid gap-4">
                    <div class="rounded-3xl bg-lime-300 p-6">
                        <p class="text-xs font-medium text-slate-800">Data Points</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-900">520k+</p>
                        <p class="mt-2 text-sm text-slate-800">Analyzed monthly to power smarter business strategies.</p>
                    </div>
                    <div class="flex items-center justify-between rounded-3xl bg-slate-900 p-6 text-white">
                        <p class="text-sm font-medium text-white/70">Continents</p>
                        <p class="text-3xl font-semibold">20+</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= FOOTER ================= --}}
        <footer class="border-t border-slate-200 py-8 text-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Aeline') }}. All rights reserved.</p>
        </footer>
    </body>
</html>