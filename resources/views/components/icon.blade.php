@props(['name', 'size' => 24, 'class' => ''])

@php
    $iconClass = 'lucide lucide-' . $name . ' ' . $class;
@endphp

<i data-lucide="{{ $name }}" class="{{ $iconClass }}" style="width: {{ $size }}px; height: {{ $size }}px;"></i>