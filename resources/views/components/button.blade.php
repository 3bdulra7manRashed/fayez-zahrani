{{--
|--------------------------------------------------------------------------
| Button Component
|--------------------------------------------------------------------------
|
| Purpose: Interactive triggers for forms, links, and layout functions.
| 
| Props:
|   - variant (string): Visual color style. Values: "primary", "secondary", "ghost", "danger". Default: "primary".
|   - type (string): Button form type. Values: "button", "submit", "reset". Default: "button".
|   - disabled (boolean): Disables click actions and applies opacity changes. Default: false.
|
| Slots:
|   - default: Main label content.
|
| Example Usage:
|   <x-button variant="primary" type="submit">إرسال الرسالة</x-button>
|
--}}
@props([
    'variant' => 'primary', // primary, secondary, ghost, danger
    'type' => 'button',
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-cairo font-semibold text-[14px] px-space-24 py-space-12 rounded-md transition-normal focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none cursor-pointer active:scale-[0.98] select-none';
    
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-hover focus:ring-primary',
        'secondary' => 'bg-surface border border-border text-text-primary hover:bg-background focus:ring-secondary',
        'ghost' => 'bg-transparent text-text-primary hover:bg-border/30 hover:text-primary focus:ring-secondary',
        'danger' => 'bg-danger text-white hover:bg-red-700 focus:ring-danger',
    ];

    $variantClasses = $variants[$variant] ?? $variants['primary'];
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => "$baseClasses $variantClasses"]) }}>
    <!-- Reusable loading state using Livewire's wire:loading if present -->
    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current hidden" wire:loading.delay.class.remove="hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <span>{{ $slot }}</span>
</button>
