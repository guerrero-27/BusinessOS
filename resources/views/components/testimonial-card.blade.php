@props(['name', 'role', 'quote'])

<article class="min-w-[280px] rounded-2xl bg-[#ECEFF3] p-5 sm:min-w-0 sm:p-6">
    <div class="flex items-center gap-3">
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white font-bold text-[#111111] ring-1 ring-black/10">
            {{ strtoupper(substr($name, 0, 1)) }}
        </span>
        <div>
            <p class="text-sm font-bold text-[#111111]">{{ $name }}</p>
            <p class="text-xs text-[#6B7280]">{{ $role }}</p>
        </div>
    </div>

    <div class="mt-4 flex items-center gap-1 text-[#F59E0B]">
        @for ($i = 0; $i < 5; $i++)
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/>
            </svg>
        @endfor
    </div>

    <p class="mt-4 text-sm leading-6 text-[#374151]">{{ $quote }}</p>
</article>
