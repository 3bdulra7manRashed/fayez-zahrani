@php
    $readerPdfPath = filter_var($book->pdf_path, FILTER_VALIDATE_URL)
        ? 'books/' . $book->slug . '.pdf'
        : $book->pdf_path;

    $meta = [
        ['label' => 'الطبعة', 'value' => $book->edition],
        ['label' => 'عدد الصفحات', 'value' => $book->pages_count ? number_format($book->pages_count) . ' صفحة' : null],
        ['label' => 'المقاس', 'value' => $book->dimensions],
        ['label' => 'الناشر', 'value' => $book->publisher],
        ['label' => 'تاريخ النشر', 'value' => $book->published_at?->format('Y-m-d')],
    ];
@endphp

<div class="bg-[#fbfcf8] pb-12">
    <section class="mx-auto max-w-[1360px] px-4 py-6 sm:px-6 lg:px-9">
        <a href="{{ route('home') }}" class="mb-5 inline-flex items-center gap-2 rounded-md text-[14px] font-bold text-text-secondary transition hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 rotate-180" aria-hidden="true">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
            العودة إلى الرئيسية
        </a>

        <div class="grid gap-4 lg:grid-cols-[330px_1fr]">
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

    <section id="reader" class="mx-auto max-w-[1360px] px-4 sm:px-6 lg:px-9">
        <div class="overflow-hidden rounded-xl border border-border bg-white shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-border bg-white p-4">
                <h2 class="flex items-center gap-2 text-[18px] font-extrabold text-primary">
                    تصفح الكتاب مباشرة
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                        <path d="M2 4h7a4 4 0 0 1 4 4v12a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 4h-7a4 4 0 0 0-4 4v12a3 3 0 0 1 3-3h8z"/>
                    </svg>
                </h2>
                <span class="text-[13px] text-text-secondary">{{ $book->title }}</span>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

            <div x-data="pdfViewer('{{ asset('storage/' . $readerPdfPath) }}')" x-init="init()" class="bg-[#f4f1e8]">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-border bg-teal-tint p-3 text-primary">
                    <div class="flex items-center gap-2">
                        <button @click="prevPage" :disabled="pageNum <= 1" class="inline-flex h-9 items-center justify-center rounded-md border border-primary/20 bg-white px-4 text-[12px] font-bold transition hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-40">السابق</button>
                        <button @click="nextPage" :disabled="pageNum >= numPages" class="inline-flex h-9 items-center justify-center rounded-md border border-primary/20 bg-white px-4 text-[12px] font-bold transition hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-40">التالي</button>
                    </div>
                    <div class="text-[13px] font-bold">
                        الصفحة <span x-text="pageNum"></span> من <span x-text="numPages || '-'"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="zoomOut" class="flex h-9 w-9 items-center justify-center rounded-md border border-primary/20 bg-white text-lg font-bold transition hover:bg-primary hover:text-white" aria-label="تصغير">-</button>
                        <button @click="zoomIn" class="flex h-9 w-9 items-center justify-center rounded-md border border-primary/20 bg-white text-lg font-bold transition hover:bg-primary hover:text-white" aria-label="تكبير">+</button>
                    </div>
                </div>

                <div class="relative flex min-h-[520px] justify-center overflow-auto p-4 sm:p-8" style="max-height: 780px;">
                    <div x-show="loading" class="absolute inset-0 z-10 flex items-center justify-center bg-[#fbfcf8]/90 text-[14px] font-bold text-primary">
                        جار تحميل الكتاب...
                    </div>
                    <canvas id="pdf-canvas" class="max-w-full border border-border bg-white shadow-[0_18px_45px_-28px_rgba(31,93,67,0.65)]"></canvas>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="mx-auto mt-4 max-w-[1360px] px-4 sm:px-6 lg:px-9">
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

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pdfViewer', (url) => ({
                url,
                pdfDoc: null,
                pageNum: 1,
                numPages: 0,
                scale: window.innerWidth < 640 ? 0.8 : 1.25,
                ctx: null,
                canvas: null,
                loading: true,

                init() {
                    if (!window.pdfjsLib) {
                        this.loading = false;
                        return;
                    }

                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                    this.canvas = document.getElementById('pdf-canvas');
                    this.ctx = this.canvas.getContext('2d');

                    pdfjsLib.getDocument(this.url).promise
                        .then((pdfDoc) => {
                            this.pdfDoc = pdfDoc;
                            this.numPages = pdfDoc.numPages;
                            this.renderPage(this.pageNum);
                        })
                        .catch(() => {
                            this.loading = false;
                        });
                },

                renderPage(num) {
                    if (!this.pdfDoc) return;

                    this.loading = true;
                    this.pdfDoc.getPage(num).then((page) => {
                        const viewport = page.getViewport({ scale: this.scale });
                        this.canvas.height = viewport.height;
                        this.canvas.width = viewport.width;

                        page.render({
                            canvasContext: this.ctx,
                            viewport,
                        }).promise.then(() => {
                            this.loading = false;
                        });
                    });
                },

                prevPage() {
                    if (this.pageNum <= 1) return;
                    this.pageNum--;
                    this.renderPage(this.pageNum);
                },

                nextPage() {
                    if (this.pageNum >= this.numPages) return;
                    this.pageNum++;
                    this.renderPage(this.pageNum);
                },

                zoomIn() {
                    this.scale += 0.2;
                    this.renderPage(this.pageNum);
                },

                zoomOut() {
                    if (this.scale <= 0.6) return;
                    this.scale -= 0.2;
                    this.renderPage(this.pageNum);
                },
            }));
        });
    </script>
@endpush
