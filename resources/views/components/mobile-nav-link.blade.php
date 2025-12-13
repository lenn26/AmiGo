@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-lg transition text-[#3499FE] font-semibold'
            : 'text-lg transition text-[#333333] font-medium hover:text-[#3499FE]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
