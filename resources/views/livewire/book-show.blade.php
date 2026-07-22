@php
    $readerPdfPath = $book->pdf_url;

    $meta = [
        ['label' => 'الطبعة', 'value' => $book->edition],
        ['label' => 'عدد الصفحات', 'value' => $book->pages_count ? number_format($book->pages_count) . ' صفحة' : null],
        ['label' => 'المقاس', 'value' => $book->dimensions],
        ['label' => 'الناشر', 'value' => $book->publisher],
        ['label' => 'تاريخ النشر', 'value' => $book->published_at?->format('Y-m-d')],
    ];
@endphp

<div class="bg-[#fbfcf8] pb-12">
    <!-- Local PDF.js Static Build -->
    <script src="{{ asset('vendor/pdfjs/pdf.min.js') }}"></script>

    <!-- Book Details Section -->
    <section class="mx-auto max-w-[1360px] px-4 py-6 sm:px-6 lg:px-9">
        <a href="{{ route('home') }}" class="mb-5 inline-flex items-center gap-2 rounded-md text-[14px] font-bold text-text-secondary transition hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 rotate-180" aria-hidden="true">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
            العودة إلى الرئيسية
        </a>

        <div class="grid gap-4 lg:grid-cols-[330px_1fr]">
            <!-- Sidebar: Cover & Quick Stats -->
            <aside class="rounded-xl border border-border bg-white p-5 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]">
                <div class="mx-auto w-full max-w-[230px] overflow-hidden rounded-lg border border-border bg-[#f6f4ec] shadow-[0_22px_36px_-30px_rgba(31,93,67,0.75)]">
                    @if($book->cover_path)
                        <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="aspect-[3/4] w-full object-cover">
                    @else
                        <div class="c{{ ($book->id % 8) + 1 }} flex aspect-[3/4] items-center justify-center p-6 text-center text-lg font-extrabold leading-8 text-white">
                            {{ $book->title }}
                        </div>
                    @endif
                </div>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="rounded-lg border border-border bg-[#fbfcf8] p-3 text-center">
                        <span class="block text-[12px] text-text-secondary">القراءات</span>
                        <strong class="mt-1 block text-lg text-primary">{{ number_format($book->views_count) }}</strong>
                    </div>
                    <div class="rounded-lg border border-border bg-[#fbfcf8] p-3 text-center">
                        <span class="block text-[12px] text-text-secondary">التحميلات</span>
                        <strong class="mt-1 block text-lg text-primary">{{ number_format($book->downloads_count) }}</strong>
                    </div>
                </div>

                <div class="mt-4">
                    <livewire:download-button :book="$book" :large="true" />
                </div>

                <a href="#reader" class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-primary/20 bg-teal-tint px-6 py-3 text-[14px] font-extrabold text-primary transition hover:bg-primary hover:text-white">
                    قراءة مباشرة
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </a>
            </aside>

            <!-- Book Information Column -->
            <article class="rounded-xl border border-border bg-white p-6 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)] lg:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-border pb-5">
                    <div>
                        <p class="text-[13px] font-bold text-secondary">تفاصيل الكتاب</p>
                        <h1 class="mt-2 max-w-[850px] text-[30px] font-extrabold leading-[1.35] text-primary sm:text-[40px]">{{ $book->title }}</h1>
                    </div>
                    <span class="rounded-full bg-teal-tint px-4 py-2 text-[12px] font-bold text-primary">متاح للقراءة والتحميل</span>
                </div>

                @if($book->description)
                    <p class="mt-5 max-w-[940px] whitespace-pre-line text-[15px] leading-9 text-text-secondary">{{ $book->description }}</p>
                @endif

                <div class="mt-7 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($meta as $item)
                        @if($item['value'])
                            <div class="rounded-lg border border-border bg-[#fbfcf8] p-4">
                                <span class="block text-[12px] font-bold text-text-secondary">{{ $item['label'] }}</span>
                                <strong class="mt-1 block text-[14px] leading-7 text-text-primary">{{ $item['value'] }}</strong>
                            </div>
                        @endif
                    @endforeach
                </div>
            </article>
        </div>
    </section>

    <!-- PDF Reader Section -->
    <section id="reader" class="mx-auto max-w-[1360px] px-4 sm:px-6 lg:px-9">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="flex items-center gap-2 text-[18px] font-extrabold text-primary">
                تصفح الكتاب مباشرة
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                    <path d="M2 4h7a4 4 0 0 1 4 4v12a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 4h-7a4 4 0 0 1 4 4v12a3 3 0 0 1 3-3h8z"/>
                </svg>
            </h2>
        </div>

        <x-pdf-reader :url="$readerPdfPath" :title="$book->title" />
    </section>

    <!-- Related Books Section -->
    @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
        <section id="related-books" class="mx-auto mt-8 max-w-[1360px] px-4 sm:px-6 lg:px-9">
            <div class="rounded-xl border border-border bg-white p-6 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]">
                <h2 class="mb-5 flex items-center gap-2 text-[18px] font-extrabold text-primary">
                    كتب ذات صلة
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                        <path d="M2 4h7a4 4 0 0 1 4 4v12a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 4h-7a4 4 0 0 0-4 4v12a3 3 0 0 1 3-3h8z"/>
                    </svg>
                </h2>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedBooks as $related)
                        <article class="book-card-hover flex flex-col rounded-lg border border-border bg-white p-3 shadow-xs">
                            <a href="{{ route('book.show', $related->slug) }}" class="mx-auto block w-[112px] overflow-hidden rounded border border-border bg-[#f6f4ec]">
                                @if($related->cover_path)
                                    <img src="{{ asset('storage/' . $related->cover_path) }}" alt="{{ $related->title }}" class="aspect-[3/4] w-full object-cover">
                                @else
                                    <div class="c{{ ($related->id % 8) + 1 }} flex aspect-[3/4] items-center justify-center p-3 text-center text-xs font-bold leading-5 text-white">
                                        {{ $related->title }}
                                    </div>
                                @endif
                            </a>
                            <div class="mt-3 flex flex-1 flex-col">
                                <h3 class="line-clamp-2 min-h-[48px] text-center text-[14px] font-extrabold leading-6 text-text-primary">
                                    <a href="{{ route('book.show', $related->slug) }}" class="hover:text-primary transition">{{ $related->title }}</a>
                                </h3>
                                <div class="mt-auto pt-3">
                                    <a href="{{ route('book.show', $related->slug) }}" class="inline-flex h-9 w-full items-center justify-center rounded-md border border-primary/20 bg-teal-tint text-[12px] font-bold text-primary transition hover:bg-primary hover:text-white">
                                        عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Message Form Section -->
    <section id="contact" class="mx-auto mt-8 max-w-[1360px] px-4 sm:px-6 lg:px-9">
        <div class="rounded-xl border border-border bg-white p-5 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]">
            <h2 class="mb-4 flex items-center gap-2 text-[18px] font-extrabold text-primary">
                مراسلة حول هذا الكتاب
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </h2>
            <livewire:book-message-form :book="$book" />
        </div>
    </section>
</div>
