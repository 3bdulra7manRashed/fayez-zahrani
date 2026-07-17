{{--
|--------------------------------------------------------------------------
| Empty State Component
|--------------------------------------------------------------------------
|
| Purpose: Displays consistent placeholder UI when databases, searches, or feedback boxes have zero items.
| 
| Props:
|   - title (string, required): Heading of the empty state alert.
|   - description (string, required): Guideline or description.
|   - icon (string, optional): Lucide icon identifier. Default: null.
|
| Slots:
|   - illustration: Vector graphic or custom design elements.
|   - action: Navigation links or primary buttons to reset filters/refresh.
|
| Example Usage:
|   <x-empty-state title="لا توجد إصدارات" description="لم يتم العثور على كتب مطابقة لمعايير البحث.">
|       <x-slot:illustration>
|           <img src="/images/search-empty.svg" alt="" />
|       </x-slot:illustration>
|       <x-slot:action>
|           <x-button variant="primary" wire:click="resetFilters">عرض كل الكتب</x-button>
|       </x-slot:action>
|   </x-empty-state>
|
--}}
@props([
    'title',
    'description',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center p-8 border border-dashed border-border rounded-lg bg-surface/50 max-w-md mx-auto my-6 animate-fade-in']) }}>
    @if(isset($illustration))
        <div class="mb-4 text-text-secondary select-none">
            {{ $illustration }}
        </div>
    @elseif($icon)
        <!-- Lucide icon fallback if provided -->
        <div class="mb-4 p-4 rounded-full bg-background text-secondary select-none">
            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                @if($icon === 'search')
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                @elseif($icon === 'book')
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                @else
                    <path d="M22 12h-6l-2 3h-4l-2-3H2C1 12 1 13 1 14v6c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2v-6c0-1-1-2-1-2zM21 8l-9 5-9-5 9-5 9 5z"/>
                @endif
            </svg>
        </div>
    @endif

    <h3 class="text-heading-s font-bold text-text-primary mb-1.5 font-cairo">{{ $title }}</h3>
    <p class="text-body-small text-text-secondary mb-5">{{ $description }}</p>

    @if(isset($action))
        <div class="flex items-center gap-3">
            {{ $action }}
        </div>
    @endif
</div>
