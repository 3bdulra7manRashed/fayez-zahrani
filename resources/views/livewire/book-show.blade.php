<div class="bg-[#fbfcf8] pb-12">
    @php
        $meta = [
            ['label' => 'الطبعة', 'value' => $book->edition],
            ['label' => 'عدد الصفحات', 'value' => $book->pages_count ? number_format($book->pages_count) . ' صفحة' : null],
            ['label' => 'المقاس', 'value' => $book->dimensions],
            ['label' => 'الناشر', 'value' => $book->publisher],
            ['label' => 'تاريخ النشر', 'value' => $book->published_at?->format('Y-m-d')],
        ];
    @endphp

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

    <!-- PDF Reader Section (PDF.js Canvas Renderer) -->
    <section id="reader" class="mx-auto max-w-[1360px] px-4 sm:px-6 lg:px-9">
        <div class="my-8 bg-slate-50 border border-slate-200 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-4 px-2">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span>📖</span> تصفح الكتاب مباشرة
                </h3>
                <livewire:download-button :book="$book" />
            </div>

            @if($book->pdf_path && $book->pdf_url)
                <div
                    x-data="{
                        pdfDoc: null,
                        currentPage: 1,
                        totalPages: 0,
                        loading: true,
                        error: false,
                        scale: 1.5,
                        rendering: false,

                        async init() {
                            try {
                                const pdfjsLib = await this.loadPdfJs();
                                const pdfUrl = "{{ route('books.stream', $book->id) }}";
                                const loadingTask = pdfjsLib.getDocument(pdfUrl);
                                this.pdfDoc = await loadingTask.promise;
                                this.totalPages = this.pdfDoc.numPages;
                                this.loading = false;
                                await this.renderPage(this.currentPage);
                            } catch (e) {
                                console.error('PDF Load Error:', e);
                                this.loading = false;
                                this.error = true;
                            }
                        },

                        loadPdfJs() {
                            return new Promise((resolve, reject) => {
                                if (window.pdfjsLib) {
                                    resolve(window.pdfjsLib);
                                    return;
                                }
                                const script = document.createElement('script');
                                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
                                script.onload = () => {
                                    if (window.pdfjsLib) {
                                        window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                                        resolve(window.pdfjsLib);
                                    } else {
                                        reject(new Error('PDF.js failed to load'));
                                    }
                                };
                                script.onerror = () => reject(new Error('Failed to load PDF.js script'));
                                document.head.appendChild(script);
                                setTimeout(() => reject(new Error('PDF.js load timeout')), 15000);
                            });
                        },

                        async renderPage(num) {
                            if (!this.pdfDoc || this.rendering) return;
                            this.rendering = true;
                            try {
                                const page = await this.pdfDoc.getPage(num);
                                const canvas = this.$refs.canvas;
                                const ctx = canvas.getContext('2d');
                                const viewport = page.getViewport({ scale: this.scale });
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;
                                await page.render({ canvasContext: ctx, viewport: viewport }).promise;
                            } catch (e) {
                                console.error('Render error:', e);
                            }
                            this.rendering = false;
                        },

                        async prevPage() {
                            if (this.currentPage <= 1) return;
                            this.currentPage--;
                            await this.renderPage(this.currentPage);
                            this.$refs.viewer.scrollTop = 0;
                        },

                        async nextPage() {
                            if (this.currentPage >= this.totalPages) return;
                            this.currentPage++;
                            await this.renderPage(this.currentPage);
                            this.$refs.viewer.scrollTop = 0;
                        },

                        async goToPage(e) {
                            let num = parseInt(e.target.value);
                            if (isNaN(num) || num < 1) num = 1;
                            if (num > this.totalPages) num = this.totalPages;
                            this.currentPage = num;
                            await this.renderPage(this.currentPage);
                        }
                    }"
                >
                    {{-- Loading State --}}
                    <div x-show="loading" class="flex items-center justify-center h-[600px] bg-white rounded-xl border border-slate-200">
                        <div class="text-center text-slate-500">
                            <svg class="animate-spin h-10 w-10 mx-auto mb-4 text-[#1F5D43]" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-base font-bold text-slate-700">جاري تحميل الكتاب...</p>
                            <p class="text-sm text-slate-400 mt-1">يرجى الانتظار قليلاً</p>
                        </div>
                    </div>

                    {{-- Error State --}}
                    <div x-show="error" x-cloak class="flex flex-col items-center justify-center h-[400px] bg-amber-50 rounded-xl border border-amber-200">
                        <p class="text-lg font-bold text-amber-800 mb-4">⚠️ تعذّر تحميل ملف الكتاب</p>
                        <a href="{{ route('books.download', $book->id) }}" class="px-6 py-3 bg-[#1F5D43] text-white rounded-xl shadow font-bold hover:bg-[#174a35] transition">
                            تحميل الكتاب مباشرة
                        </a>
                    </div>

                    {{-- PDF Viewer --}}
                    <div x-show="!loading && !error" x-cloak>
                        {{-- Navigation Controls --}}
                        <div class="flex items-center justify-center gap-3 mb-3 p-3 bg-white rounded-xl border border-slate-200">
                            <button @click="prevPage()" :disabled="currentPage <= 1"
                                class="px-4 py-2 rounded-lg bg-[#1F5D43] text-white text-sm font-bold disabled:opacity-30 disabled:cursor-not-allowed hover:bg-[#174a35] transition">
                                ← السابقة
                            </button>

                            <div class="flex items-center gap-2 text-sm font-medium text-slate-700" dir="ltr">
                                <span>Page</span>
                                <input type="number" :value="currentPage" @change="goToPage($event)" min="1" :max="totalPages"
                                    class="w-16 text-center px-2 py-1.5 rounded-lg border border-slate-300 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#1F5D43]/30 focus:border-[#1F5D43]">
                                <span>of</span>
                                <span class="font-bold" x-text="totalPages"></span>
                            </div>

                            <button @click="nextPage()" :disabled="currentPage >= totalPages"
                                class="px-4 py-2 rounded-lg bg-[#1F5D43] text-white text-sm font-bold disabled:opacity-30 disabled:cursor-not-allowed hover:bg-[#174a35] transition">
                                التالية →
                            </button>
                        </div>

                        {{-- Canvas Container --}}
                        <div x-ref="viewer" class="overflow-auto max-h-[750px] bg-slate-100 rounded-xl border border-slate-200 flex justify-center p-4">
                            <canvas x-ref="canvas" class="shadow-lg rounded bg-white"></canvas>
                        </div>

                        {{-- Download fallback link --}}
                        <div class="mt-3 text-center">
                            <a href="{{ route('books.download', $book->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-[#1F5D43] transition font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l-4-4m4 4l4-4M4 19h16"/></svg>
                                تحميل الكتاب لقراءته على جهازك
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-12 text-center text-amber-800 bg-amber-50 rounded-xl border border-amber-200 font-medium">
                    ⚠️ ملف الـ PDF غير متاح حالياً أو لم يتم رفعه بشكل صحيح.
                </div>
            @endif
        </div>
    </section>

    <!-- Related Books Section -->
    @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
        <section id="related-books" class="mx-auto mt-8 max-w-[1360px] px-4 sm:px-6 lg:px-9">
            <div class="rounded-xl border border-border bg-white p-6 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]">
                <h2 class="mb-5 flex items-center gap-2 text-[18px] font-extrabold text-primary">
                    كتب ذات صلة
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                        <path d="M2 4h7a4 4 0 0 1 4 4v12a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 4h-7a4 4 0 0 1 4 4v12a3 3 0 0 1 3-3h8z"/>
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
