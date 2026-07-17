<div>
    @if($large)
        <button wire:click="download" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3.5 text-[14px] font-extrabold text-white shadow-[0_14px_26px_-18px_rgba(31,93,67,0.85)] transition hover:bg-primary-hover disabled:cursor-wait disabled:opacity-70" aria-label="تحميل الكتاب">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                <path d="M12 3v12m0 0-4-4m4 4 4-4M4 19h16"/>
            </svg>
            تحميل الكتاب
        </button>
    @else
        <button wire:click="download" wire:loading.attr="disabled" class="inline-flex h-9 w-full items-center justify-center gap-1 rounded-md bg-primary px-3 text-[12px] font-bold text-white transition hover:bg-primary-hover disabled:cursor-wait disabled:opacity-70" aria-label="تحميل الكتاب">
            تحميل
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5" aria-hidden="true">
                <path d="M12 3v12m0 0-4-4m4 4 4-4M4 19h16"/>
            </svg>
        </button>
    @endif
</div>
