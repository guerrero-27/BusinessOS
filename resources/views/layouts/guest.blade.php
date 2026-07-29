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
    <body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 w-full max-w-5xl rounded-[2rem] border border-slate-200 bg-white p-3 shadow-sm sm:p-4">
                <div class="flex items-center justify-between rounded-[1.5rem] bg-slate-900 px-5 py-4 text-white sm:px-6">
                    <a href="/" class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-sm font-semibold">BO</span>
                        <span>
                            <span class="block text-base font-semibold">{{ config('app.name', 'BusinessOS') }}</span>
                            <span class="block text-sm text-slate-300">Secure access to your workspace</span>
                        </span>
                    </a>
                    <a href="/" class="text-sm font-medium text-slate-300 transition hover:text-white">
                        Back home
                    </a>
                </div>
            </div>

            <div class="w-full max-w-md overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/80 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
