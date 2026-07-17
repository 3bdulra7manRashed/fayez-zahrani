@props([
    'sticky' => true,
])

<div
    class="w-full border-b border-border bg-white/95 shadow-[0_8px_30px_-28px_rgba(31,93,67,0.45)] backdrop-blur {{ $sticky ? 'sticky top-0 z-sticky' : 'relative' }} select-none"
>
    <div class="mx-auto flex flex-wrap sm:flex-nowrap h-auto sm:h-[76px] w-full max-w-[1400px] items-center justify-between gap-y-3 gap-x-4 px-4 py-3.5 sm:py-0 sm:px-6 lg:px-9">
        <!-- Logo Area (RTL start / Right) -->
        <a href="{{ request()->routeIs('home') ? '#' : route('home') }}" class="order-1 flex items-center gap-2 rounded-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 shrink-0" aria-label="الذهاب للرئيسية">
            <span class="flex h-10 w-11 shrink-0 items-center justify-center text-primary">
                <svg viewBox="0 0 64 48" fill="none" class="h-10 w-11" aria-hidden="true">
                    <path d="M7 12c11 0 18 4 23 12v18C23 34 15 31 7 31V12Z" fill="#f2ead8" stroke="currentColor" stroke-width="2"/>
                    <path d="M57 12c-11 0-18 4-23 12v18c7-8 15-11 23-11V12Z" fill="#f7f3e8" stroke="currentColor" stroke-width="2"/>
                    <path d="M32 23v20" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M46 3c-5 5-7 10-7 17 6-3 9-8 7-17Z" fill="#2f7654"/>
                </svg>
            </span>
            <span class="leading-tight">
                <span class="block text-[20px] font-extrabold text-primary sm:text-[24px]">مكتبة</span>
                <span class="hidden text-[11px] font-semibold text-secondary sm:block">فايز بن سعيد الزهراني</span>
            </span>
        </a>

        <!-- Search Bar (Visual Center) -->
        <div class="order-3 sm:order-2 w-full sm:flex-1 sm:max-w-[480px] sm:mx-6 md:mx-12">
            <livewire:book-search />
        </div>

        <!-- Primary CTA (RTL end / Left) -->
        <div class="order-2 sm:order-3 shrink-0">
            <a 
                href="{{ request()->routeIs('home') ? '#books' : route('home') . '#books' }}" 
                class="inline-flex h-10 sm:h-11 items-center justify-center gap-2 rounded-lg bg-primary px-4 sm:px-5 text-[13px] sm:text-[14px] font-bold text-white shadow-[0_12px_22px_-16px_rgba(31,93,67,0.9)] transition hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
            >
                تصفح الكتب
            </a>
        </div>
    </div>
</div>
