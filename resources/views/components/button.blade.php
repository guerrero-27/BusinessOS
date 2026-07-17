<button {{ $attributes->merge([
        'class'=> 'inline-flex items-center rounded-lg bg--indigo-600 px-4 py-2 font-medium text-white transition hover:bg:indigo-700'
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