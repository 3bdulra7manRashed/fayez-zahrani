{{--
|--------------------------------------------------------------------------
| Skeleton Loading Component
|--------------------------------------------------------------------------
|
| Purpose: Displays shimmering layouts during data retrieval/page transitions.
| 
| Props:
|   - variant (string, required): Semantic type representing the layout.
|     Values: "book-card", "stat-card", "button", "avatar", "table-row", "search-result".
|   - lines (int): Number of text shim rows inside text-based variants. Default: 1.
|
| Example Usage:
|   <div role="status" aria-label="تحميل البيانات">
|       <x-skeleton variant="book-card" />
|   </div>
|
--}}
@props([
    'variant',
    'lines' => 1,
])

<div {{ $attributes->merge(['class' => 'animate-pulse select-none pointer-events-none']) }} aria-hidden="true">
    @if($variant === 'book-card')
        <div class="space-y-4">
            <!-- Book Cover -->
            <div class="w-full aspect-[3/4] bg-border rounded-lg"></div>
            <!-- Title Line -->
            <div class="h-4 bg-border rounded w-3/4"></div>
            <!-- Metadata Line -->
            <div class="h-3 bg-border rounded w-1/2"></div>
        </div>
    @elseif($variant === 'stat-card')
        <div class="border border-border p-6 rounded-md bg-surface/30 flex items-center justify-between">
            <div class="space-y-2 w-1/2">
                <!-- Label -->
                <div class="h-3 bg-border rounded w-2/3"></div>
                <!-- Metric Number -->
                <div class="h-7 bg-border rounded w-full"></div>
            </div>
            <!-- Icon block -->
            <div class="h-10 w-10 bg-border rounded-md"></div>
        </div>
    @elseif($variant === 'button')
        <div class="h-10 bg-border rounded-md w-28"></div>
    @elseif($variant === 'avatar')
        <div class="h-12 w-12 bg-border rounded-full"></div>
    @elseif($variant === 'table-row')
        <div class="flex items-center justify-between py-4 border-b border-border gap-4">
            <div class="h-4 bg-border rounded w-1/4"></div>
            <div class="h-4 bg-border rounded w-1/3"></div>
            <div class="h-4 bg-border rounded w-12"></div>
            <div class="h-4 bg-border rounded w-16"></div>
        </div>
    @elseif($variant === 'search-result')
        <div class="flex gap-4 p-4 border-b border-border">
            <div class="h-16 w-12 bg-border rounded"></div>
            <div class="space-y-2 flex-1">
                <div class="h-4 bg-border rounded w-1/2"></div>
                <div class="h-3 bg-border rounded w-3/4"></div>
            </div>
        </div>
    @else
        <!-- Fallback generic text shims -->
        <div class="space-y-2">
            @for($i = 0; $i < $lines; $i++)
                <div class="h-3.5 bg-border rounded {{ $i === $lines - 1 ? 'w-2/3' : 'w-full' }}"></div>
            @endfor
        </div>
    @endif
</div>
