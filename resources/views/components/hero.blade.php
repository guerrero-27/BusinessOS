<section class="container mx-auto grid gap-10 px-4 pb-16 pt-10 sm:px-6 md:grid-cols-2 md:items-center lg:px-8 lg:pb-24">
    <div>
        <p class="inline-flex items-center rounded-full bg-white px-3 py-1 text-xs font-semibold tracking-wide text-[#6B7280] ring-1 ring-black/5">BusinessOS Operations Hub</p>
        <h1 class="mt-5 text-4xl font-bold leading-tight text-[#111111] sm:text-5xl lg:text-6xl">
            Everything in One Place.
        </h1>
        <p class="mt-5 max-w-xl text-base leading-7 text-[#6B7280]">
            Manage customers, products, suppliers, and inventory in one powerful platform.
        </p>

        <a href="#about" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#111111] transition hover:text-[#4CAF50]">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white ring-1 ring-black/10">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M8 5.14v13.72a1 1 0 0 0 1.51.86l10.98-6.86a1 1 0 0 0 0-1.72L9.51 4.28A1 1 0 0 0 8 5.14Z" />
                </svg>
            </span>
            Explore platform overview
        </a>

        <div class="mt-8 max-w-md rounded-3xl bg-white p-5 shadow-sm ring-1 ring-black/5">
            <p class="text-sm font-semibold text-[#111111]">Core modules in one view</p>
            <p class="mt-1 text-sm text-[#6B7280]">Customers, Products, Categories, Inventory, Suppliers, and Reports.</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('login') }}" class="inline-flex items-center rounded-full bg-[#111111] px-4 py-2 text-xs font-semibold text-white">Login</a>
                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-[#111111] px-4 py-2 text-xs font-semibold text-white">Create Account</a>
            </div>
        </div>
    </div>

    <div class="relative mx-auto w-full max-w-lg">
        <div class="absolute right-2 top-2 z-20 rounded-2xl bg-white p-3 shadow-xl ring-1 ring-black/5 sm:right-0">
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                    <span class="h-7 w-7 rounded-full border-2 border-white bg-[#A7F3D0]"></span>
                    <span class="h-7 w-7 rounded-full border-2 border-white bg-[#93C5FD]"></span>
                    <span class="h-7 w-7 rounded-full border-2 border-white bg-[#FDE68A]"></span>
                </div>
                <p class="text-xs font-semibold text-[#111111]">Auth + Verified Access</p>
            </div>
        </div>

        <div class="relative flex items-end justify-center pt-14">
            <img src="{{ asset('images/patungans-phone-2.svg') }}" alt="BusinessOS mobile analytics" class="relative z-0 w-52 -rotate-6 rounded-[2.2rem] shadow-2xl sm:w-56" />
            <img src="{{ asset('images/patungans-phone-1.svg') }}" alt="BusinessOS mobile dashboard" class="-ml-16 w-56 rotate-6 rounded-[2.2rem] shadow-2xl sm:w-64" />
        </div>
    </div>
</section>
