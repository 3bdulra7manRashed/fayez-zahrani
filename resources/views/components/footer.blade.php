<footer class="mt-10 border-t border-border bg-white">
    <div class="mx-auto flex w-full max-w-[1400px] flex-col gap-4 px-4 py-6 text-[13px] text-text-secondary sm:px-6 lg:px-9">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-primary">
                <span class="flex h-9 w-10 items-center justify-center">
                    <svg viewBox="0 0 64 48" fill="none" class="h-9 w-10" aria-hidden="true">
                        <path d="M7 12c11 0 18 4 23 12v18C23 34 15 31 7 31V12Z" fill="#f2ead8" stroke="currentColor" stroke-width="2"/>
                        <path d="M57 12c-11 0-18 4-23 12v18c7-8 15-11 23-11V12Z" fill="#f7f3e8" stroke="currentColor" stroke-width="2"/>
                        <path d="M32 23v20" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <span>
                    <span class="block text-[16px] font-extrabold">مكتبة فايز الزهراني</span>
                    <span class="block text-[12px] font-medium text-text-secondary">للقراءة والتحميل المباشر</span>
                </span>
            </a>

            <nav aria-label="روابط التذييل">
                <ul class="flex flex-wrap items-center gap-x-5 gap-y-2 font-semibold">
                    <li><a href="{{ route('home') }}#books" class="transition hover:text-primary">الكتب</a></li>
                    <li><a href="{{ route('home') }}#about" class="transition hover:text-primary">عن الشيخ</a></li>
                    <li><a href="{{ route('home') }}#contact" class="transition hover:text-primary">تواصل</a></li>
                </ul>
            </nav>
        </div>

        <div class="flex flex-col gap-2 border-t border-border pt-4 sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ now()->year }} جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>
