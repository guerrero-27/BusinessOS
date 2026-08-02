@props(['title', 'description'])

<article class="rounded-2xl bg-[#ECEFF3] p-6 sm:p-7">
    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#111111] text-white">
        {{ $slot }}
    </span>
    <h3 class="mt-5 text-xl font-bold text-[#111111]">{{ $title }}</h3>
    <p class="mt-2 text-sm leading-6 text-[#6B7280]">{{ $description }}</p>
    <a href="#" class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-[#4CAF50] transition hover:text-[#2f7b35]">
        Learn More
        <span aria-hidden="true">&rarr;</span>
    </a>
</article>
