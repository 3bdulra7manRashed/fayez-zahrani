{{--
|--------------------------------------------------------------------------
| Divider Component
|--------------------------------------------------------------------------
|
| Purpose: A layout line divider separating visual segments.
| 
| Props:
|   - style (string): Type of border. Values: "solid", "dashed". Default: "solid".
|   - vertical (boolean): If true, renders a vertical divider instead of horizontal. Default: false.
|
| Example Usage:
|   <x-divider style="dashed" />
|   <div class="flex items-center">
|       <span>الباب الأول</span>
|       <x-divider :vertical="true" class="mx-3 h-4" />
|       <span>الباب الثاني</span>
|   </div>
|
--}}
@props([
    'style' => 'solid', // solid, dashed
    'vertical' => false,
])

@php
    $styleClasses = [
        'solid' => 'border-solid',
        'dashed' => 'border-dashed',
    ];

    $borderStyle = $styleClasses[$style] ?? $styleClasses['solid'];
    
    $layoutClass = $vertical 
        ? "border-r h-full self-stretch $borderStyle" 
        : "border-t w-full my-4 $borderStyle";
@endphp

<div {{ $attributes->merge(['class' => "$layoutClass border-border"]) }} role="none"></div>
