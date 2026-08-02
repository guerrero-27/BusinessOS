<section id="product" class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <div class="relative overflow-hidden rounded-2xl bg-[#111111] px-6 py-8 text-white sm:px-8 lg:px-10 lg:py-10">
        <span class="mx-auto inline-flex rounded-full bg-gradient-to-r from-[#7ED957] to-[#4CAF50] px-4 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-[#111111]">
            Reports and visibility
        </span>

        <div class="mt-6 grid gap-8 md:grid-cols-2 md:items-center">
            <div>
                <h2 class="text-3xl font-bold leading-tight sm:text-4xl">Turn day-to-day activity into operational reports</h2>
                <p class="mt-3 max-w-md text-sm leading-6 text-white/75">
                    Review customer activity, low-stock risk, and inventory movement trends using filterable report views designed for daily decisions.
                </p>
                <a href="{{ route('reports.index') }}" class="mt-6 inline-flex items-center rounded-full bg-gradient-to-r from-[#7ED957] to-[#4CAF50] px-5 py-2.5 text-sm font-semibold text-[#111111] transition hover:opacity-90">
                    Open Reports
                </a>
            </div>

            <div class="md:justify-self-end">
                <div class="rounded-2xl bg-white/10 p-3 ring-1 ring-white/20 backdrop-blur">
                    <img src="{{ asset('images/patungans-app-shot.svg') }}" alt="BusinessOS app screenshot" class="h-auto w-full max-w-sm rounded-xl object-cover" />
                </div>
            </div>
        </div>
    </div>
</section>
