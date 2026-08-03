<button {{ $attributes->merge([
    'class'=> 'inline-flex items-center rounded-lg bg-[#111111] px-4 py-2 font-medium text-white transition hover:bg-black focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:ring-offset-2'
    ])}}
>

    {{ $slot }}
    
</button>


{{-- using props attribute --}}
{{-- @props([
    'variant' => 'primary',
])
<button {{$attributes->merge([
    'class' => $variant === 'primary'
    ? 'bg-indigo-600 text-white'
    : 'bg-red-600 text-white'
])}}>

</button> --}}