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
    <section class="min-h-[calc(100vh-76px)] flex items-center py-12 md:py-20 bg-white border-b border-border relative overflow-hidden">
        <!-- Subtle background pattern/ambient glow -->
        <div class="absolute inset-0 pointer-events-none opacity-30 bg-[radial-gradient(circle_at_70%_30%,rgba(31,93,67,0.08),transparent_50%)]" aria-hidden="true"></div>
        <div class="library-pattern absolute inset-y-0 left-0 hidden w-1/3 opacity-40 lg:block" aria-hidden="true"></div>

        <x-container>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Content Column (Right on RTL) -->
                <div class="lg:col-span-7 text-center lg:text-right space-y-6 sm:space-y-8 order-2 lg:order-1">
                    <span class="inline-flex items-center gap-2 rounded-full border border-primary/10 bg-primary/5 px-4 py-1.5 text-[12px] font-bold text-primary">
                        المكتبة الرقمية الرسمية
                    </span>

                    <h1 class="text-[34px] md:text-[46px] lg:text-[54px] font-extrabold leading-[1.2] text-text-primary font-cairo">
                        مكتبة علمية موثوقة<br class="hidden sm:block"> لنشر العلم النافع
                    </h1>

                    <p class="mx-auto lg:mx-0 max-w-[600px] text-[16px] md:text-[18px] leading-8 text-text-secondary font-cairo font-light">
                        تصفّح واقرأ وحمّل كتب ورسائل مختارة لفضيلة الشيخ فايز بن سعيد الزهراني في واجهة بسيطة وتجربة تصفح هادئة وخالية من المشتتات.
                    </p>

                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-2">
                        <a href="#books" class="focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded-md">
                            <x-button variant="primary" class="h-12 px-8">تصفح الكتب</x-button>
                        </a>
                        <a href="#latest" class="focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded-md">
                            <x-button variant="secondary" class="h-12 px-8">أحدث الإصدارات</x-button>
                        </a>
                    </div>
                </div>

                <!-- Book Preview Column (Left on RTL) -->
                <div class="lg:col-span-5 flex justify-center order-1 lg:order-2">
                    <div class="relative w-full aspect-[4/3] max-w-[440px] flex items-center justify-center select-none pointer-events-none" aria-hidden="true">
                        @php $takenBooks = $latestBooks->take(3); @endphp
                        @if($takenBooks->count() >= 3)
                            <!-- Back Left Book -->
                            <div class="absolute w-[140px] h-[190px] rounded-lg shadow-card c3 transform -translate-x-[50px] -rotate-6 z-10 overflow-hidden border border-white/10 flex flex-col justify-between p-4 text-white/90">
                                <span class="text-[10px] font-bold">مكتبة تربوية</span>
                                <h4 class="text-[12px] font-bold font-cairo line-clamp-3 leading-snug">{{ $takenBooks[1]->title }}</h4>
                            </div>

                            <!-- Back Right Book -->
                            <div class="absolute w-[140px] h-[190px] rounded-lg shadow-card c4 transform translate-x-[50px] rotate-6 z-10 overflow-hidden border border-white/10 flex flex-col justify-between p-4 text-white/90">
                                <span class="text-[10px] font-bold">دراسات إسلامية</span>
                                <h4 class="text-[12px] font-bold font-cairo line-clamp-3 leading-snug">{{ $takenBooks[2]->title }}</h4>
                            </div>

                            <!-- Center/Front Book -->
                            <div class="absolute w-[165px] h-[225px] rounded-lg shadow-floating c1 transform z-20 overflow-hidden border border-white/20 flex flex-col justify-between p-5 text-white">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-accent">موصى به</span>
                                    <span class="text-[9px] bg-white/20 px-1.5 py-0.5 rounded-sm">١٤٤٧ هـ</span>
                                </div>
                                <h3 class="text-body-small font-bold font-cairo line-clamp-3 leading-snug">{{ $takenBooks[0]->title }}</h3>
                                <div class="text-[9px] text-white/60">الشيخ فايز بن سعيد الزهراني</div>
                            </div>
                        @else
                            <!-- Fallback placeholders if DB is empty -->
                            <div class="absolute w-[140px] h-[190px] rounded-lg shadow-card c3 transform -translate-x-[50px] -rotate-6 z-10 flex flex-col justify-between p-4 text-white/90 border border-white/10">
                                <span class="text-[10px] font-bold">مكتبة تربوية</span>
                                <h4 class="text-[12px] font-bold font-cairo line-clamp-3 leading-snug">التربية الأخلاقية وتطبيقاتها في السلوك</h4>
                            </div>
                            <div class="absolute w-[140px] h-[190px] rounded-lg shadow-card c4 transform translate-x-[50px] rotate-6 z-10 flex flex-col justify-between p-4 text-white/90 border border-white/10">
                                <span class="text-[10px] font-bold">دراسات إسلامية</span>
                                <h4 class="text-[12px] font-bold font-cairo line-clamp-3 leading-snug">توجيهات قرآنية لبناء المجتمع المعاصر</h4>
                            </div>
                            <div class="absolute w-[165px] h-[225px] rounded-lg shadow-floating c1 transform z-20 flex flex-col justify-between p-5 text-white border border-white/20">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-accent">الإصدار الأحدث</span>
                                    <span class="text-[9px] bg-white/20 px-1.5 py-0.5 rounded-sm">١٤٤٧ هـ</span>
                                </div>
                                <h3 class="text-body-small font-bold font-cairo line-clamp-3 leading-snug">دليل Mربي المعاصر في بناء الشخصية الإسلامية</h3>
                                <div class="text-[9px] text-white/60">الشيخ فايز بن سعيد الزهراني</div>
                            </div>
                        @endif
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

    <section id="latest" class="mx-auto mt-6 max-w-[1400px] px-4 sm:px-6 lg:px-9">
        <div class="py-12 md:py-16 text-center">
            <span class="inline-block rounded-full border border-accent/30 bg-accent/10 px-4 py-1 text-[12px] font-bold text-accent">مختارات حديثة</span>
            <h2 class="mt-4 text-[28px] font-extrabold leading-tight text-text-primary sm:text-[34px]">أحدث الكتب</h2>
            <p class="mx-auto mt-3 max-w-[520px] text-[15px] leading-8 text-text-secondary">
                آخر الإصدارات المضافة إلى المكتبة، للوصول السريع إلى أحدث مؤلفات الشيخ.
            </p>
        </div>

        <div class="overflow-hidden rounded-xl border border-primary/15 bg-[#f3f7f0] shadow-[0_20px_48px_-38px_rgba(31,93,67,0.75)]">

            <div class="grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @forelse($latestBooks->take(5) as $book)
                    <article class="book-card-hover flex min-h-[268px] flex-col rounded-lg border border-primary/10 bg-white p-4 shadow-[0_14px_30px_-26px_rgba(31,93,67,0.7)]">
                        <span class="mb-3 self-start rounded-full bg-teal-tint px-3 py-1 text-[11px] font-bold text-primary">جديد</span>
                        <a href="{{ route('book.show', $book->slug) }}" class="mx-auto block w-[122px] overflow-hidden rounded border border-border bg-[#f6f4ec]">
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
                                <livewire:download-button :book="$book" :key="'latest-dl-'.$book->id" />
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-lg border border-dashed border-primary/20 bg-white/70 p-8 text-center text-text-secondary">لا توجد كتب حديثة بعد.</div>
                @endforelse
            </div>

            <div class="border-t border-primary/10 bg-white/60 px-5 py-4 text-center">
                <a href="#books" class="inline-flex h-11 items-center justify-center rounded-lg bg-primary px-6 text-[14px] font-bold text-white shadow-[0_12px_24px_-18px_rgba(31,93,67,0.85)] transition hover:bg-primary-hover">
                    الانتقال إلى كل الكتب
                </a>
            </div>
        </div>
    </section>

    {{-- ── Visual Break: Full-width spacer ── --}}
    <div class="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-9 pt-14 pb-2" aria-hidden="true">
        <div class="h-px bg-gradient-to-l from-transparent via-primary/20 to-transparent"></div>
    </div>

    {{-- ── All Books: Library Section Header ── --}}
    <section id="books" class="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-9">
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
