{{--
|--------------------------------------------------------------------------
| Container Component
|--------------------------------------------------------------------------
|
| Purpose: A layout wrapper that bounds and centers content dynamically.
| 
| Props:
|   - size (string): "default" (max-w-1180px), "narrow" (max-w-768px), "wide" (max-w-1440px). Default: "default".
|   - fluid (boolean): If true, spans 100% of the viewport width.
|
| Slots:
|   - default: Main slot for wrapped page contents.
|
| Example Usage:
|   <x-container size="narrow">
|       <p>Content locked to a comfortable reading width.</p>
|   </x-container>
|
--}}
@props([
    'size' => 'default', // default, narrow, wide
    'fluid' => false,
])

@php
    $sizes = [
        'default' => 'max-w-[1180px]',
        'narrow' => 'max-w-[768px]',
        'wide' => 'max-w-[1440px]',
    ];

    $widthClass = $fluid ? 'max-w-full' : ($sizes[$size] ?? $sizes['default']);
@endphp

<div {{ $attributes->merge(['class' => "$widthClass mx-auto px-6 w-full"]) }}>
    {{ $slot }}
</div>
