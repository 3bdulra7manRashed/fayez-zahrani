{{--
|--------------------------------------------------------------------------
| Card Component
|--------------------------------------------------------------------------
|
| Purpose: Display chunks of grouped information in grids or lists.
| 
| Props:
|   - hoverable (boolean): Applies hover elevation and shifts card position. Default: true.
|
| Example Usage:
|   <x-card :hoverable="true">
|       <h3 class="text-heading-s">عنوان الكارت</h3>
|       <p>محتوى الكارت</p>
|   </x-card>
|
--}}
@props([
    'hoverable' => true,
])

<div {{ $attributes->merge(['class' => 'bg-surface border border-border p-space-24 rounded-lg shadow-card transition-normal' . ($hoverable ? ' hover:-translate-y-1 hover:shadow-floating hover:border-primary/20' : '')]) }}>
    {{ $slot }}
</div>
