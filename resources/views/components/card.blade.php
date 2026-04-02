@props(['padding' => 'md', 'shadow' => 'classic', 'rounded' => 'none'])

@php
    $paddingClasses = [
        'none' => '',
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
    ];

    $shadowClasses = [
        'none' => '',
        'classic' => 'shadow-classic',
        'classic-inset' => 'shadow-classic-inset',
    ];

    $roundedClasses = [
        'none' => '',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
    ];

    $classes = 'bg-white border-2 border-gray-300 ' .
               ($paddingClasses[$padding] ?? $paddingClasses['md']) . ' ' .
               ($shadowClasses[$shadow] ?? $shadowClasses['classic']) . ' ' .
               ($roundedClasses[$rounded] ?? $roundedClasses['none']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>