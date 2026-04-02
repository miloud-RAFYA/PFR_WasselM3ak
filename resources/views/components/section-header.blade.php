@props(['title', 'subtitle' => null, 'align' => 'center'])

@php
    $alignClasses = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ];

    $classes = $alignClasses[$align] ?? $alignClasses['center'];
@endphp

<div class="mb-8 {{ $classes }}">
    <h2 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-gray-300 pb-2">{{ $title }}</h2>
    @if($subtitle)
        <p class="text-base text-gray-600 max-w-2xl mx-auto leading-relaxed">{{ $subtitle }}</p>
    @endif
</div>