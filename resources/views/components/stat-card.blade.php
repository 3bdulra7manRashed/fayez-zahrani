{{--
|--------------------------------------------------------------------------
| Stat Card Component
|--------------------------------------------------------------------------
|
| Purpose: Highlights statistics or numeric aggregates on dashboard summaries.
| 
| Props:
|   - label (string, required): The description of the statistic.
|   - value (string, required): The numeric metric.
|
| Slots:
|   - icon: Optional SVG graphic for design branding.
|
| Example Usage:
|   <x-stat-card label="إجمالي مشاهدات الكتب" value="12,500">
|       <x-slot:icon>
|           <svg class="h-6 w-6">...</svg>
|       </x-slot:icon>
|   </x-stat-card>
|
--}}
@props([
    'label',
    'value',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'bg-surface border border-border p-space-24 rounded-md shadow-card flex items-center justify-between transition-normal hover:shadow-floating hover:border-primary/10 select-none']) }}>
    <div class="space-y-1">
        <p class="text-caption text-text-secondary">{{ $label }}</p>
        <h3 class="text-heading-xl font-bold text-primary tracking-tight leading-none mt-1">{{ $value }}</h3>
    </div>
    @if($icon)
        <div class="p-space-12 bg-primary/5 text-primary rounded-md flex items-center justify-center">
            {{ $icon }}
        </div>
    @endif
</div>
