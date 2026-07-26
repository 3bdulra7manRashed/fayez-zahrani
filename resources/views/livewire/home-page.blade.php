@php
    $statItems = [
        [
            'label' => 'إجمالي الكتب',
            'value' => number_format($stats['total_books']),
            'hint' => 'كتاب',
            'icon' => 'book',
        ],
        [
            'label' => 'إجمالي القراءات',
            'value' => number_format($stats['total_views']),
            'hint' => 'قراءة',
            'icon' => 'eye',
        ],
        [
            'label' => 'إجمالي التحميلات',
            'value' => number_format($stats['total_downloads']),
            'hint' => 'تحميل',
            'icon' => 'download',
        ],
    ];
@endphp

<div class="bg-[#fbfcf8] pb-10">
    <!-- Clean Minimalist Hero Banner -->
    <section class="my-6 md:my-8 max-w-5xl mx-auto px-4">
        <div class="bg-gradient-to-b from-emerald-50/60 to-white border border-emerald-100/60 rounded-3xl p-6 md:p-10 text-center shadow-sm">
            <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-[1.01]">
                <img src="{{ asset('images/hero-logo.png') }}" 
                     alt="مكتبة الشيخ فايز بن سعيد الزهراني" 
                     class="max-h-48 md:max-h-60 w-auto mx-auto object-contain drop-shadow-sm">
            </a>
        </div>
    </section>

    <section id="stats" class="mx-auto mt-3 max-w-[1400px] px-4 sm:px-6 lg:px-9">
        <div class="grid gap-3 md:grid-cols-3">
            @foreach($statItems as $item)
                <div class="rounded-xl border border-border bg-white p-6 shadow-[0_16px_36px_-30px_rgba(31,93,67,0.65)]">
                    <div class="flex items-center justify-between gap-5">
                        <div>
                            <p class="text-[13px] text-text-secondary">{{ $item['label'] }}</p>
                            <strong class="mt-1 block text-[28px] font-extrabold leading-tight text-text-primary">{{ $item['value'] }}</strong>
                            <span class="text-[12px] text-text-secondary">{{ $item['hint'] }}</span>
                        </div>
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg bg-teal-tint text-primary">
                            @if($item['icon'] === 'book')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-8 w-8" aria-hidden="true">
                                    <path d="M2 4h7a4 4 0 0 1 4 4v12a3 3 0 0 0-3-3H2z"/>
                                    <path d="M22 4h-7a4 4 0 0 0-4 4v12a3 3 0 0 1 3-3h8z"/>
                                </svg>
                            @elseif($item['icon'] === 'eye')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-8 w-8" aria-hidden="true">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            @elseif($item['icon'] === 'download')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-8 w-8" aria-hidden="true">
                                    <path d="M12 3v12m0 0-4-4m4 4 4-4M4 19h16"/>
                                </svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-8 w-8" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <path d="M16 2v4M8 2v4M3 10h18"/>
                                </svg>
                            @endif
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ── All Books: Library Section Header ── --}}
    <section id="books" class="mx-auto mt-6 max-w-[1400px] px-4 sm:px-6 lg:px-9">
        <div class="py-12 md:py-16 text-center">
            <span class="inline-block rounded-full border border-accent/30 bg-accent/10 px-4 py-1 text-[12px] font-bold text-accent">المكتبة الكاملة</span>
            <h2 class="mt-4 text-[28px] font-extrabold leading-tight text-text-primary sm:text-[34px]">
                جميع الكتب
            </h2>
            <p class="mx-auto mt-3 max-w-[520px] text-[15px] leading-8 text-text-secondary">
                تصفح جميع مؤلفات الشيخ فايز بن سعيد الزهراني، واقرأ أو حمّل الكتاب الذي تبحث عنه.
            </p>
        </div>

        <div class="rounded-xl border border-border bg-white p-5 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @forelse($books as $book)
                    <article wire:key="book-card-{{ $book->id }}" class="book-card-hover flex min-h-[252px] flex-col rounded-lg border border-border bg-white p-3 shadow-sm">
                        <a href="{{ route('book.show', $book->slug) }}" class="mx-auto block w-[112px] overflow-hidden rounded border border-border bg-[#f6f4ec]">
                            @if($book->cover_path)
                                <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="aspect-[3/4] w-full object-cover">
                            @else
                                <div class="c{{ ($book->id % 8) + 1 }} flex aspect-[3/4] items-center justify-center p-3 text-center text-xs font-bold leading-5 text-white">{{ $book->title }}</div>
                            @endif
                        </a>
                        <div class="mt-3 flex flex-1 flex-col">
                            <h3 class="line-clamp-2 min-h-[48px] text-center text-[14px] font-extrabold leading-6 text-text-primary">
                                <a href="{{ route('book.show', $book->slug) }}">{{ $book->title }}</a>
                            </h3>
                            <div class="mt-2 flex items-center justify-center gap-5 text-[12px] text-text-secondary">
                                <span>{{ number_format($book->views_count) }} قراءة</span>
                                <span>{{ number_format($book->downloads_count) }} تحميل</span>
                            </div>
                            <div class="mt-auto grid grid-cols-2 gap-2 pt-3">
                                <a href="{{ route('book.show', $book->slug) }}" class="inline-flex h-9 items-center justify-center rounded-md border border-primary/20 bg-teal-tint text-[12px] font-bold text-primary transition hover:bg-primary hover:text-white">قراءة</a>
                                <livewire:download-button :book="$book" :key="'home-dl-'.$book->id" />
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-lg border border-dashed border-border bg-[#fbfcf8] p-8 text-center text-text-secondary">
                        لا توجد كتب مطابقة لبحثك.
                    </div>
                @endforelse
            </div>
        </div>
    </section>


</div>
