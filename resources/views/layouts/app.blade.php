<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BusinessOS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 overflow-x-hidden">
        <div class="flex min-h-screen">
            <x-sidebar/>

            <div class="flex min-h-screen flex-1 flex-col">
                <x-dashboard-navbar/>

                <main class="p-4 pt-20 sm:p-6 sm:pt-20 lg:p-8 lg:pt-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebar = document.getElementById('app-sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                const closeButton = document.getElementById('close-sidebar-btn');

                if (!sidebar || !backdrop) return;

                const openSidebar = function () {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                };

                const closeSidebar = function () {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                };

                window.addEventListener('toggle-sidebar', openSidebar);
                backdrop.addEventListener('click', closeSidebar);
                closeButton?.addEventListener('click', closeSidebar);
                window.addEventListener('resize', function () {
                    if (window.innerWidth >= 1024) {
                        backdrop.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });
        </script>
    </body>
</html>
