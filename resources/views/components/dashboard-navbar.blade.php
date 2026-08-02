<header class="fixed inset-x-0 top-0 z-30 flex h-16 items-center justify-between gap-3 border-b border-black/10 bg-[#F4F5F7]/95 px-4 backdrop-blur sm:gap-4 sm:px-6 lg:static lg:z-auto lg:bg-[#F4F5F7] lg:backdrop-blur-none">
    <button type="button" class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition hover:bg-white hover:text-[#2f7b35] lg:hidden" aria-label="Open sidebar" onclick="window.dispatchEvent(new CustomEvent('toggle-sidebar'))">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="hidden max-w-sm flex-1 sm:block">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input type="text" placeholder="Search..." class="w-full rounded-xl border border-black/10 bg-white py-2 pl-9 pr-4 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#4CAF50]">
        </div>
    </div>

    <div class="flex items-center gap-1 sm:gap-2">
        <button class="relative rounded-lg p-2 text-gray-500 transition hover:bg-white hover:text-[#2f7b35]">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </button>

        <div class="hidden h-6 w-px bg-gray-200 sm:block"></div>

        <div class="flex items-center gap-2.5 pl-1">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#111111] text-sm font-semibold text-white">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="hidden leading-tight sm:block">
                <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>
        </div>
    </div>
</header>
