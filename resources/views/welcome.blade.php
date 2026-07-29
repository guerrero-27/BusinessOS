<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BusinessOS') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        @php
            $customerCount = \App\Models\Customer::count();
            $productCount = \App\Models\Product::count();
            $activeCategoryCount = \App\Models\Category::where('is_active', true)->count();
        @endphp

        <div class="mx-auto flex min-h-screen max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8">
            <header class="mb-8 flex flex-col gap-4 rounded-[1.75rem] border border-slate-200 bg-white/80 px-5 py-4 shadow-sm backdrop-blur sm:flex-row sm:items-center sm:justify-between">
                <a href="/" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20">BO</span>
                    <span>
                        <span class="block text-lg font-semibold text-slate-900">{{ config('app.name', 'BusinessOS') }}</span>
                        <span class="block text-sm text-slate-500">Customers • Products • Inventory</span>
                    </span>
                </a>

                @if (Route::has('login'))
                    <nav class="flex flex-wrap items-center gap-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
                                Go to dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-indigo-300 hover:text-indigo-700">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700">
                                    Create account
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="grid flex-1 gap-6 lg:grid-cols-[1.15fr_0.85fr]">
                <section class="rounded-[2rem] border border-slate-200 bg-gradient-to-br from-indigo-600 via-indigo-500 to-slate-900 p-8 text-white shadow-2xl shadow-indigo-600/10 sm:p-10 lg:p-12">
                    <div class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-sm font-medium backdrop-blur">
                        <span class="mr-2 h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                        BusinessOS overview
                    </div>

                    <h1 class="mt-6 text-4xl font-semibold leading-tight sm:text-5xl">
                        Run your retail operations from one clean dashboard.
                    </h1>

                    <p class="mt-4 max-w-xl text-base text-indigo-100 sm:text-lg">
                        Keep customer records, stock movements, and product details in sync without the clutter.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-slate-100">
                                Open dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-slate-100">
                                Sign in
                            </a>
                        @endauth
                        <a href="#features" class="inline-flex items-center rounded-full border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            See features
                        </a>
                    </div>

                    <div class="mt-8 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                            <p class="text-2xl font-semibold">{{ $customerCount }}</p>
                            <p class="mt-1 text-sm text-indigo-100">Customers</p>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                            <p class="text-2xl font-semibold">{{ $productCount }}</p>
                            <p class="mt-1 text-sm text-indigo-100">Products</p>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                            <p class="text-2xl font-semibold">{{ $activeCategoryCount }}</p>
                            <p class="mt-1 text-sm text-indigo-100">Active categories</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Business snapshot</p>
                            <p class="text-sm text-slate-500">A quick view of what your team can manage.</p>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">
                            Live
                        </span>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm font-medium text-slate-500">Customer profiles</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">Organized</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm font-medium text-slate-500">Inventory control</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">Real-time</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">Quick actions</p>
                        <ul class="mt-3 space-y-2 text-sm text-slate-600">
                            <li class="flex items-center justify-between rounded-xl bg-white px-3 py-2">
                                <span>Customers</span>
                                <span class="font-medium text-indigo-600">Manage profiles</span>
                            </li>
                            <li class="flex items-center justify-between rounded-xl bg-white px-3 py-2">
                                <span>Products</span>
                                <span class="font-medium text-indigo-600">Track details</span>
                            </li>
                            <li class="flex items-center justify-between rounded-xl bg-white px-3 py-2">
                                <span>Inventory</span>
                                <span class="font-medium text-indigo-600">Adjust stock</span>
                            </li>
                        </ul>
                    </div>
                </section>
            </main>

            <section id="features" class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-semibold text-indigo-600">Customer management</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Keep every relationship in one place.</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Store contact details, activity, and status in a simple workflow built for daily operations.</p>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-semibold text-indigo-600">Inventory insights</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Stay ahead of stock issues.</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Monitor low stock, track product movement, and keep replenishment visible at a glance.</p>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-semibold text-indigo-600">Built for focus</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Less noise, more clarity.</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">A calm interface designed to help your team move faster with less effort.</p>
                </div>
            </section>

            <footer class="mt-8 border-t border-slate-200 pt-6 text-sm text-slate-500">
                <p>BusinessOS helps growing teams stay organized with clear customer and inventory workflows.</p>
            </footer>
        </div>
    </body>
</html>
