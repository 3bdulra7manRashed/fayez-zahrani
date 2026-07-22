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
    <!-- Hero Section -->
    <section class="relative min-h-[calc(100vh-76px)] flex items-center bg-white border-b border-border overflow-hidden py-16 md:py-24">
        <!-- Subtle Background Details -->
        <div class="absolute inset-0 pointer-events-none opacity-40 bg-[radial-gradient(circle_at_80%_20%,rgba(31,93,67,0.06),transparent_50%)]" aria-hidden="true"></div>
        <div class="library-pattern absolute inset-y-0 left-0 hidden w-1/3 opacity-30 lg:block" aria-hidden="true"></div>

        <x-container>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                <!-- Text Content Area (RTL start / Right) -->
                <div class="lg:col-span-6 space-y-8 text-center lg:text-right order-2 lg:order-1">
                    <div class="space-y-4">
                        <span class="inline-flex items-center gap-2 rounded-full border border-primary/10 bg-primary/5 px-4 py-1.5 text-[13px] font-bold text-primary tracking-wide">
                            المكتبة الرقمية الرسمية
                        </span>
                        
                        <h1 class="text-[36px] sm:text-[46px] lg:text-[56px] font-extrabold leading-[1.15] text-text-primary tracking-tight font-cairo">
                            مكتبة علمية موثوقة<br class="hidden sm:block"> لنشر العلم النافع
                        </h1>
                    </div>

                    <p class="mx-auto lg:mx-0 max-w-[580px] text-[16px] md:text-[18px] leading-[1.8] text-text-secondary font-cairo font-light">
                        كتب ورسائل مختارة لفضيلة الشيخ فايز بن سعيد الزهراني، مرتبة في واجهة بسيطة وتجربة تصفح هادئة وخالية من المشتتات للبحث والقراءة والتحميل.
                    </p>

                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                        <a href="#books" class="focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded-lg">
                            <x-button variant="primary" class="h-12 sm:h-14 px-8 sm:px-10 text-[14px] sm:text-[15px] shadow-[0_16px_30px_-12px_rgba(31,93,67,0.35)] transition-all duration-300 hover:scale-[1.02]">
                                تصفح الكتب
                            </x-button>
                        </a>
                    </div>
                </div>

                <!-- Book Showcase Area (RTL end / Left) -->
                <div class="lg:col-span-6 flex justify-center items-center order-1 lg:order-2">
                    <div class="relative flex items-end justify-center px-4 pt-4 pb-12 sm:pt-6 sm:pb-16 w-full max-w-[540px] transform -translate-y-4 md:-translate-y-8 lg:-translate-y-12">
                        @forelse($books->take(4) as $book)
                            @php
                                $rotationClass = '';
                                $marginClass = '-mx-3 sm:-mx-4 lg:-mx-5';
                                if ($loop->index === 0) {
                                    $rotationClass = 'rotate-[-8deg] translate-y-3 hover:translate-y-1 hover:rotate-[-4deg]';
                                } elseif ($loop->index === 1) {
                                    $rotationClass = 'rotate-[3deg] -translate-y-2 hover:-translate-y-4 hover:rotate-[6deg] z-10';
                                } elseif ($loop->index === 2) {
                                    $rotationClass = 'rotate-[-3deg] translate-y-1 hover:translate-y-[-1deg] hover:rotate-[-6deg] z-10';
                                } else {
                                    $rotationClass = 'rotate-[8deg] translate-y-4 hover:translate-y-2 hover:rotate-[4deg]';
                                }
                            @endphp
                            <a 
                                href="{{ route('book.show', $book->slug) }}" 
                                class="block w-[100px] sm:w-[130px] lg:w-[155px] aspect-[3/4] overflow-hidden rounded-lg border border-white/90 bg-white shadow-[0_20px_45px_-12px_rgba(0,0,0,0.18)] transition-all duration-300 transform select-none {{ $marginClass }} {{ $rotationClass }}"
                                aria-label="عرض تفاصيل كتاب {{ $book->title }}"
                            >
                                @if($book->cover_path)
                                    <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
                                @else
                                    <div class="c{{ ($book->id % 8) + 1 }} flex h-full items-center justify-center p-4 text-center text-[10px] sm:text-xs font-bold leading-5 text-white">
                                        {{ $book->title }}
                                    </div>
                                @endif
                            </a>
                        @empty
                            <div class="rounded-xl bg-[#eef2e7] border border-border px-8 py-6 text-primary text-center">
                                أضف الكتب من لوحة التحكم لتظهر هنا.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </x-container>
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
