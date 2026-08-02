@props(['size' => 'lg', 'avatars' => []])

@php
    $containerSizes = [
        'sm' => 'h-[260px] w-[260px]',
        'md' => 'h-[340px] w-[340px]',
        'lg' => 'h-[260px] w-[260px] sm:h-[340px] sm:w-[340px] lg:h-[400px] lg:w-[400px]',
    ];

    $bubbleSizes = [
        'sm' => 'h-11 w-11',
        'md' => 'h-14 w-14',
        'lg' => 'h-12 w-12 md:h-16 md:w-16',
    ];

    $centerSizes = [
        'sm' => 'h-14 w-14 rounded-xl',
        'md' => 'h-16 w-16 rounded-2xl',
        'lg' => 'h-16 w-16 rounded-2xl md:h-20 md:w-20',
    ];

    $containerClass = $containerSizes[$size] ?? $containerSizes['lg'];
    $bubbleClass = $bubbleSizes[$size] ?? $bubbleSizes['lg'];
    $centerClass = $centerSizes[$size] ?? $centerSizes['lg'];

    $avatarSources = !empty($avatars)
        ? $avatars
        : [
            asset('images/avatars/avatar-1.svg'),
            asset('images/avatars/avatar-2.svg'),
            asset('images/avatars/avatar-3.svg'),
            asset('images/avatars/avatar-4.svg'),
            asset('images/avatars/avatar-5.svg'),
        ];
@endphp

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="relative {{ $containerClass }}">
        <div class="absolute inset-0 m-auto h-[90%] w-[90%] rounded-full bg-[#E9E9F5]"></div>

        <svg class="absolute inset-0 h-full w-full" viewBox="0 0 400 400" fill="none" aria-hidden="true">
            <path d="M200 200V110" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round"/>
            <path d="M200 200H120" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round"/>
            <path d="M200 200H292" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round"/>
            <path d="M220 200V320" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round"/>

            <path d="M200 160H284V116" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M200 242H286V286" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M200 160H126V120" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M200 240H124V286" stroke="#C7CBD8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <div class="absolute left-1/2 top-1/2 z-20 -translate-x-1/2 -translate-y-1/2 bg-[#1A1A1A] shadow-lg {{ $centerClass }} flex items-center justify-center">
            <svg class="h-7 w-7 text-white md:h-8 md:w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 14.5c-1.933 1.933-5.067 1.933-7 0s-1.933-5.067 0-7 5.067-1.933 7 0L12 11l3.5 3.5c1.933 1.933 5.067 1.933 7 0s1.933-5.067 0-7-5.067-1.933-7 0L12 11"/>
            </svg>
        </div>

        <div class="absolute left-[24%] top-[24%] z-30 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white shadow-md ring-1 ring-black/5 {{ $bubbleClass }} overflow-hidden">
            <img src="{{ $avatarSources[0] ?? asset('images/avatars/avatar-1.svg') }}" alt="Community member" class="h-full w-full object-cover" loading="lazy">
        </div>
        <div class="absolute left-[80%] top-[30%] z-30 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white shadow-md ring-1 ring-black/5 {{ $bubbleClass }} overflow-hidden">
            <img src="{{ $avatarSources[1] ?? asset('images/avatars/avatar-2.svg') }}" alt="Community member" class="h-full w-full object-cover" loading="lazy">
        </div>
        <div class="absolute left-[80%] top-[68%] z-30 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white shadow-md ring-1 ring-black/5 {{ $bubbleClass }} overflow-hidden">
            <img src="{{ $avatarSources[2] ?? asset('images/avatars/avatar-3.svg') }}" alt="Community member" class="h-full w-full object-cover" loading="lazy">
        </div>
        <div class="absolute left-[24%] top-[70%] z-30 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white shadow-md ring-1 ring-black/5 {{ $bubbleClass }} overflow-hidden">
            <img src="{{ $avatarSources[3] ?? asset('images/avatars/avatar-4.svg') }}" alt="Community member" class="h-full w-full object-cover" loading="lazy">
        </div>
        <div class="absolute left-[56%] top-[84%] z-30 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white shadow-md ring-1 ring-black/5 {{ $bubbleClass }} overflow-hidden">
            <img src="{{ $avatarSources[4] ?? asset('images/avatars/avatar-5.svg') }}" alt="Community member" class="h-full w-full object-cover" loading="lazy">
        </div>
    </div>
</div>
