{{--
|--------------------------------------------------------------------------
| Section Header Component
|--------------------------------------------------------------------------
|
| Purpose: Standard banner for page or grid sections displaying titles, descriptions, and CTA actions.
| 
| Props:
|   - eyebrow (string, optional): A text badge rendered above the title.
|   - title (string, optional): Heading text (can also be passed via main slot).
|   - subtitle (string, optional): Help text or description.
|   - divider (boolean): Renders a bottom border separator. Default: false.
|   - align (string): Alignment of headings, either "right" (default) or "center".
|
| Slots:
|   - default (title fallback): The main header title text if no title prop is passed.
|   - icon: Custom SVG graphic displayed to the right (RTL prefix) of the title.
|   - action: Area for buttons or links on the left side of the header.
|
| Example Usage:
|   <x-section-header eyebrow="الإصدارات" title="كتب الشيخ" :divider="true">
|       <x-slot:icon>
|           <svg class="h-6 w-6" fill="currentColor">...</svg>
|       </x-slot:icon>
|       <x-slot:action>
|           <x-button variant="secondary">عرض الكل</x-button>
|       </x-slot:action>
|   </x-section-header>
|
--}}
@props([
    'eyebrow' => null,
    'title' => null,
    'subtitle' => null,
    'divider' => false,
    'align' => 'right', // right, center
])

<div {{ $attributes->merge(['class' => 'w-full flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 ' . ($divider ? 'border-b border-border' : '') . ($align === 'center' ? ' text-center md:text-center md:justify-center md:flex-col md:items-center' : ' text-right')]) }}>
    <div class="space-y-1.5">
        @if($eyebrow)
            <span class="inline-block text-caption text-secondary tracking-wider font-semibold uppercase">{{ $eyebrow }}</span>
        @endif
        
        <div class="flex items-center gap-3 {{ $align === 'center' ? 'justify-center' : '' }}">
            @if(isset($icon))
                <div class="text-secondary select-none flex-shrink-0">
                    {{ $icon }}
                </div>
            @endif
            <h2 class="text-heading-l font-bold text-text-primary">
                {{ $title ?? $slot }}
            </h2>
        </div>

        @if($subtitle)
            <p class="text-body-small text-text-secondary mt-1">{{ $subtitle }}</p>
        @endif
    </div>

    @if(isset($action))
        <div class="flex items-center gap-3 flex-shrink-0 {{ $align === 'center' ? 'justify-center' : '' }}">
            {{ $action }}
        </div>
    @endif
</div>
