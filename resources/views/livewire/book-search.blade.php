<div class="flex h-11 items-center gap-3 rounded-full border border-transparent bg-[#f3f6ef] px-4 text-text-secondary shadow-[0_12px_24px_-22px_rgba(31,93,67,0.55)] focus-within:border-primary/30 focus-within:bg-white">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-[18px] w-[18px] shrink-0 text-primary" aria-hidden="true">
        <circle cx="11" cy="11" r="7"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="search" id="search-input" wire:model.live.debounce.300ms="search" class="min-w-0 flex-1 border-0 bg-transparent text-right text-[13px] text-text-primary outline-none placeholder:text-text-secondary" placeholder="ابحث عن كتاب أو موضوع..." aria-label="ابحث عن كتاب أو موضوع">
</div>
