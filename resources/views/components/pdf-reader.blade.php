@props([
    'url',
    'downloadUrl' => null,
    'title' => null,
])

@php
    $download = $downloadUrl ?? $url;
@endphp

<script>
    (function () {
        const initPdfReaderComponent = () => {
            if (typeof window.Alpine !== 'undefined' && !window.Alpine.data('pdfReader')) {
                window.Alpine.data('pdfReader', (config) => ({
                    url: config.url,
                    workerSrc: config.workerSrc,
                    pdfDoc: null,
                    pageNum: 1,
                    numPages: 0,
                    scale: 1.0,
                    loading: true,
                    error: false,
                    renderTask: null,

                    init() {
                        if (typeof pdfjsLib === 'undefined') {
                            console.error('PDF.js library is not loaded.');
                            this.loading = false;
                            this.error = true;
                            return;
                        }

                        pdfjsLib.GlobalWorkerOptions.workerSrc = this.workerSrc;

                        const loadingTask = pdfjsLib.getDocument({
                            url: this.url,
                            disableRange: true,
                            disableStream: true,
                        });

                        loadingTask.promise
                            .then((pdf) => {
                                this.pdfDoc = pdf;
                                this.numPages = pdf.numPages;
                                this.loadInitialPage();
                            })
                            .catch((err) => {
                                console.error('Error loading PDF document:', err);
                                this.loading = false;
                                this.error = true;
                            });
                    },

                    loadInitialPage() {
                        if (!this.pdfDoc) return;

                        this.$nextTick(() => {
                            this.pdfDoc.getPage(1).then((page) => {
                                const container = this.$refs.container;
                                if (container && container.clientWidth > 0) {
                                    const unscaledViewport = page.getViewport({ scale: 1.0 });
                                    const availableWidth = container.clientWidth - 48;
                                    if (availableWidth > 0 && unscaledViewport.width > 0) {
                                        this.scale = availableWidth / unscaledViewport.width;
                                        this.scale = Math.max(0.5, Math.min(this.scale, 2.2));
                                    }
                                }
                                this.renderPage(1);
                            }).catch((err) => {
                                console.error('Error loading initial page:', err);
                                this.renderPage(1);
                            });
                        });
                    },

                    renderPage(num) {
                        if (!this.pdfDoc) return;
                        this.loading = true;

                        if (this.renderTask) {
                            this.renderTask.cancel();
                        }

                        this.pdfDoc.getPage(num).then((page) => {
                            const canvas = this.$refs.canvas;
                            if (!canvas) {
                                this.loading = false;
                                return;
                            }

                            const ctx = canvas.getContext('2d');
                            if (!ctx) {
                                this.loading = false;
                                return;
                            }

                            const viewport = page.getViewport({ scale: this.scale });

                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            this.renderTask = page.render({
                                canvasContext: ctx,
                                viewport: viewport,
                            });

                            this.renderTask.promise
                                .then(() => {
                                    this.loading = false;
                                    this.renderTask = null;
                                })
                                .catch((err) => {
                                    if (err && err.name !== 'RenderingCancelledException') {
                                        console.error('Render error:', err);
                                        this.loading = false;
                                    }
                                });
                        }).catch((err) => {
                            console.error('Error fetching page:', err);
                            this.loading = false;
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
                        this.scale = Math.min(this.scale + 0.2, 3.0);
                        this.renderPage(this.pageNum);
                    },

                    zoomOut() {
                        if (this.scale <= 0.4) return;
                        this.scale = Math.max(this.scale - 0.2, 0.4);
                        this.renderPage(this.pageNum);
                    },
                }));
            }
        };

        if (window.Alpine) {
            initPdfReaderComponent();
        } else {
            document.addEventListener('alpine:init', initPdfReaderComponent);
        }
    })();
</script>

<div 
    x-data="pdfReader({
        url: @js($url),
        workerSrc: @js(asset('vendor/pdfjs/pdf.worker.min.js'))
    })"
    class="overflow-hidden rounded-xl border border-border bg-white shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]"
>
    <!-- Reader Header Toolbar (6 essential controls) -->
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-border bg-teal-tint px-4 py-3 text-primary">
        <!-- Page Navigation -->
        <div class="flex items-center gap-2">
            <button 
                @click="prevPage" 
                :disabled="pageNum <= 1 || loading" 
                class="inline-flex h-9 items-center justify-center rounded-md border border-primary/20 bg-white px-3.5 text-[13px] font-bold text-primary transition hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-40 cursor-pointer"
                aria-label="الصفحة السابقة"
            >
                السابق
            </button>
            <button 
                @click="nextPage" 
                :disabled="pageNum >= numPages || loading" 
                class="inline-flex h-9 items-center justify-center rounded-md border border-primary/20 bg-white px-3.5 text-[13px] font-bold text-primary transition hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-40 cursor-pointer"
                aria-label="الصفحة التالية"
            >
                التالي
            </button>
        </div>

        <!-- Page Number Indicator -->
        <div class="text-[13px] font-bold tracking-wide">
            الصفحة <span x-text="pageNum"></span> من <span x-text="numPages || '-'"></span>
        </div>

        <!-- Zoom & Download Controls -->
        <div class="flex items-center gap-2">
            <button 
                @click="zoomOut" 
                :disabled="loading" 
                class="flex h-9 w-9 items-center justify-center rounded-md border border-primary/20 bg-white text-base font-extrabold text-primary transition hover:bg-primary hover:text-white disabled:opacity-40 cursor-pointer" 
                aria-label="تصغير"
                title="تصغير"
            >
                −
            </button>
            <button 
                @click="zoomIn" 
                :disabled="loading" 
                class="flex h-9 w-9 items-center justify-center rounded-md border border-primary/20 bg-white text-base font-extrabold text-primary transition hover:bg-primary hover:text-white disabled:opacity-40 cursor-pointer" 
                aria-label="تكبير"
                title="تكبير"
            >
                +
            </button>
            <a 
                href="{{ $download }}" 
                download 
                class="inline-flex h-9 items-center justify-center gap-1.5 rounded-md bg-primary px-3.5 text-[12px] font-bold text-white shadow-sm transition hover:bg-primary-hover"
                title="تحميل PDF"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4" aria-hidden="true">
                    <path d="M12 3v12m0 0-4-4m4 4 4-4M4 19h16"/>
                </svg>
                <span>تحميل</span>
            </a>
        </div>
    </div>

    <!-- Viewer Canvas Container & Loading/Error States -->
    <div x-ref="container" class="relative flex min-h-[520px] justify-center overflow-auto bg-[#f4f1e8] p-4 sm:p-6" style="max-height: 800px;">
        <!-- Refined Loading Indicator Matching Design System -->
        <div 
            x-show="loading" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 bg-[#fbfcf8]/90 backdrop-blur-xs text-primary"
        >
            <div class="relative flex h-10 w-10 items-center justify-center">
                <div class="h-10 w-10 rounded-full border-3 border-primary/20 border-t-primary animate-spin"></div>
            </div>
            <span class="text-[14px] font-bold text-text-primary">جاري تحميل الكتاب...</span>
        </div>

        <!-- Error Fallback -->
        <div x-show="error" class="flex flex-col items-center justify-center py-16 text-center text-text-secondary" x-cloak>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-12 w-12 text-red-500 mb-3" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <p class="text-[15px] font-bold text-text-primary">تعذر عرض ملف PDF داخل المتصفح</p>
            <a href="{{ $download }}" download class="mt-4 inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-[13px] font-bold text-white transition hover:bg-primary-hover">
                تحميل الملف مباشرة
            </a>
        </div>

        <!-- Render Canvas -->
        <canvas x-ref="canvas" x-show="!error" class="max-w-full rounded border border-border bg-white shadow-[0_18px_45px_-28px_rgba(31,93,67,0.65)]"></canvas>
    </div>
</div>
