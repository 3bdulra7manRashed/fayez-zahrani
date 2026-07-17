{{--
|--------------------------------------------------------------------------
| Badge Component
|--------------------------------------------------------------------------
|
| Purpose: Displays categories, status indicators, or counts in pill badges.
| 
| Props:
|   - variant (string): Visual color style. Values: "primary", "secondary", "success", "warning", "danger". Default: "primary".
|
| Example Usage:
|   <x-badge variant="success">مقروء</x-badge>
|
--}}
@props([
    'variant' => 'primary', // primary, secondary, success, warning, danger
])

@php
    $baseClasses = 'inline-flex items-center px-space-12 py-space-4 rounded-xl text-caption font-semibold tracking-wide font-cairo select-none';
    
    $variants = [
        'primary' => 'bg-primary/10 text-primary',
        'secondary' => 'bg-secondary/10 text-secondary',
        'success' => 'bg-success/10 text-success',
        'warning' => 'bg-warning/10 text-warning',
        'danger' => 'bg-danger/10 text-danger',
    ];

    $variantClasses = $variants[$variant] ?? $variants['primary'];
@endphp

<span {{ $attributes->merge(['class' => "$baseClasses $variantClasses"]) }}>
    {{ $slot }}
</span>
