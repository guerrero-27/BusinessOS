<nav class="sticky top-0 z-50 border-b border-black/5 bg-[#F4F5F7]/95 backdrop-blur">
    <div class="container mx-auto flex items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-2">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#7ED957] to-[#4CAF50] text-[#111111]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2 22 20 12 15 2 20Z" />
                </svg>
            </span>
            <div class="min-w-0">
                <span class="block truncate text-lg font-bold tracking-tight text-[#111111]">BusinessOS</span>
                <p class="hidden text-[11px] font-medium text-[#6B7280] sm:block">Customers · Products · Inventory</p>
            </div>
        </a>

        <div class="hidden items-center gap-7 md:flex">
            <a href="#services" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">Core Modules</a>
            <a href="#product" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">Reports</a>
            <a href="#about" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">Team Workflow</a>
            <a href="#blog" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">Use Cases</a>
        </div>

        <div class="hidden md:block">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-full bg-[#111111] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">
                    Open Dashboard
                </a>
            @else
                <a href="#demo" class="inline-flex items-center rounded-full bg-[#111111] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">
                    Create Account
                </a>
            @endauth
        </div>

        <details class="group relative md:hidden">
            <summary class="flex h-10 w-10 shrink-0 list-none items-center justify-center rounded-xl border border-black/10 bg-white text-[#111111] shadow-sm transition duration-300 hover:border-[#4CAF50]/40 hover:bg-[#f8faf7] hover:text-[#2f7b35] [&::-webkit-details-marker]:hidden">
                <span class="sr-only">Toggle menu</span>
                <span class="relative block h-4 w-5">
                    <span class="absolute left-0 top-0.5 h-0.5 w-5 rounded-full bg-current transition duration-300 ease-out group-open:translate-y-[6px] group-open:rotate-45"></span>
                    <span class="absolute left-0 top-[7px] h-0.5 w-5 rounded-full bg-current transition duration-200 ease-out group-open:opacity-0"></span>
                    <span class="absolute left-0 top-[13px] h-0.5 w-5 rounded-full bg-current transition duration-300 ease-out group-open:-translate-y-[6px] group-open:-rotate-45"></span>
                </span>
            </summary>
            <div class="absolute right-0 z-50 mt-3 w-60 max-w-[calc(100vw-2rem)] origin-top-right rounded-2xl border border-black/10 bg-white/95 p-3 shadow-2xl backdrop-blur transition duration-300 ease-out opacity-0 scale-95 -translate-y-2 pointer-events-none group-open:opacity-100 group-open:scale-100 group-open:translate-y-0 group-open:pointer-events-auto">
                <div class="flex flex-col gap-1.5">
                    <a href="#services" class="rounded-lg px-3 py-2 text-sm font-medium text-[#111111] transition hover:bg-[#F4F5F7] hover:text-[#2f7b35]">Core Modules</a>
                    <a href="#product" class="rounded-lg px-3 py-2 text-sm font-medium text-[#111111] transition hover:bg-[#F4F5F7] hover:text-[#2f7b35]">Reports</a>
                    <a href="#about" class="rounded-lg px-3 py-2 text-sm font-medium text-[#111111] transition hover:bg-[#F4F5F7] hover:text-[#2f7b35]">Team Workflow</a>
                    <a href="#blog" class="rounded-lg px-3 py-2 text-sm font-medium text-[#111111] transition hover:bg-[#F4F5F7] hover:text-[#2f7b35]">Use Cases</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="mt-2 inline-flex items-center justify-center rounded-full bg-[#111111] px-4 py-2 text-sm font-semibold text-white transition hover:bg-black">
                            Open Dashboard
                        </a>
                    @else
                        <a href="#demo" class="mt-2 inline-flex items-center justify-center rounded-full bg-[#111111] px-4 py-2 text-sm font-semibold text-white transition hover:bg-black">
                            Create Account
                        </a>
                    @endauth
                </div>
            </div>
        </details>
    </div>
</nav>
