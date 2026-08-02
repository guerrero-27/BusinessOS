@props(['title', 'description'])

<div class="py-5">
    <div class="flex items-start gap-4">
        <span class="mt-0.5 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#111111] text-white">
            {{ $slot }}
        </span>
        <div>
            <h3 class="text-base font-bold text-[#111111]">{{ $title }}</h3>
            <p class="mt-1 text-sm leading-6 text-[#6B7280]">{{ $description }}</p>
        </div>
    </div>
</div>
