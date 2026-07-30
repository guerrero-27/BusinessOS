<section class="border-y border-slate-200/70 bg-white/90 py-8" aria-label="Trusted partners">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex gap-3 overflow-x-auto pb-2">
            @foreach (range(1, 7) as $logo)
                <div class="flex min-w-[150px] items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-500 grayscale transition hover:grayscale-0">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 2a1 1 0 0 1 .894.553l1.17 2.365 2.611.38a1 1 0 0 1 .554 1.706l-1.89 1.843.446 2.6a1 1 0 0 1-1.45 1.054L10 11.27l-2.335 1.23a1 1 0 0 1-1.45-1.053l.446-2.601-1.89-1.843a1 1 0 0 1 .554-1.706l2.61-.38 1.17-2.365A1 1 0 0 1 10 2Z" />
                    </svg>
                    <span class="text-sm font-semibold">Logoipsum</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
