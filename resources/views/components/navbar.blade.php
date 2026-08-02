<nav class="sticky top-0 z-50 border-b border-black/5 bg-[#F4F5F7]/95 backdrop-blur">
    <div class="container mx-auto flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-[#7ED957] to-[#4CAF50] text-[#111111]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2 22 20 12 15 2 20Z" />
                </svg>
            </span>
            <span class="text-lg font-bold tracking-tight text-[#111111]">BusinessOS</span>
        </a>

        <div class="hidden items-center gap-7 md:flex">
            <a href="#services" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">Service</a>
            <a href="#product" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">Product</a>
            <a href="#blog" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">Blog</a>
            <a href="#about" class="text-sm font-medium text-[#111111] transition hover:text-[#4CAF50]">About Us</a>
        </div>

        <div class="hidden md:block">
            <a href="#demo" class="inline-flex items-center rounded-full bg-[#111111] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">
                Get a Demo
            </a>
        </div>

        <details class="relative md:hidden">
            <summary class="flex h-10 w-10 list-none items-center justify-center rounded-xl border border-black/10 bg-white text-[#111111]">
                <span class="sr-only">Toggle menu</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </summary>
            <div class="absolute right-0 mt-3 w-56 rounded-2xl border border-black/10 bg-white p-3 shadow-xl">
                <div class="flex flex-col gap-1.5">
                    <a href="#services" class="rounded-lg px-3 py-2 text-sm text-[#111111] hover:bg-[#F4F5F7]">Service</a>
                    <a href="#product" class="rounded-lg px-3 py-2 text-sm text-[#111111] hover:bg-[#F4F5F7]">Product</a>
                    <a href="#blog" class="rounded-lg px-3 py-2 text-sm text-[#111111] hover:bg-[#F4F5F7]">Blog</a>
                    <a href="#about" class="rounded-lg px-3 py-2 text-sm text-[#111111] hover:bg-[#F4F5F7]">About Us</a>
                    <a href="#demo" class="mt-2 inline-flex items-center justify-center rounded-full bg-[#111111] px-4 py-2 text-sm font-semibold text-white">
                        Get a Demo
                    </a>
                </div>
            </div>
        </details>
    </div>
</nav>
