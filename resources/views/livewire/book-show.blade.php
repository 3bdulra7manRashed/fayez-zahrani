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
            <!-- Book Cover Column (Clean Without Buttons) -->
            <aside class="flex flex-col items-center justify-center rounded-xl border border-border bg-white p-5 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)]">
                <div class="w-full max-w-[280px] md:max-w-[320px] rounded-2xl overflow-hidden shadow-md border border-slate-100 bg-white p-2">
                    @if($book->cover_path)
                        <img src="{{ asset('storage/' . $book->cover_path) }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-auto rounded-xl object-cover aspect-[3/4]">
                    @else
                        <div class="c{{ ($book->id % 8) + 1 }} flex aspect-[3/4] items-center justify-center p-6 text-center text-lg font-extrabold leading-8 text-white rounded-xl">
                            {{ $book->title }}
                        </div>
                    @endif
                </div>
            </aside>

            <!-- Book Information Column -->
            <article class="rounded-xl border border-border bg-white p-6 shadow-[0_18px_42px_-36px_rgba(31,93,67,0.75)] lg:p-8">
                <h1 class="text-2xl md:text-4xl font-black text-slate-900 leading-tight mb-4">{{ $book->title }}</h1>

                @if($book->description)
                    <p class="text-slate-700 text-sm md:text-base leading-relaxed md:leading-loose text-justify font-medium mb-6 whitespace-pre-line">{{ $book->description }}</p>
                @endif

                <hr class="border-slate-200/80 my-6">

                <!-- Clean Unboxed Book Metadata & Copyright -->
                <div class="pt-2 text-slate-700 text-xs md:text-sm font-medium">
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                        @if($book->edition)
                            <span>الطبعة: <strong class="font-bold text-slate-900">{{ $book->edition }}</strong></span>
                        @endif

                        @if($book->pages_count)
                            <span class="text-slate-300 font-light mx-0.5">|</span>
                            <span>عدد الصفحات: <strong class="font-bold text-slate-900">{{ $book->pages_count }} صفحة</strong></span>
                        @endif

                        @if($book->size || $book->dimensions)
                            <span class="text-slate-300 font-light mx-0.5">|</span>
                            <span>حجم الكتاب: <strong class="font-bold text-slate-900">{{ $book->size ?? $book->dimensions }}</strong></span>
                        @endif

                        @if($book->publisher)
                            <span class="text-slate-300 font-light mx-0.5">|</span>
                            <span>الناشر: <strong class="font-bold text-slate-900">{{ $book->publisher }}</strong></span>
                        @endif
                    </div>

                    <p class="text-[11px] md:text-xs text-slate-400 mt-2 font-normal">
                        لا يسمح بطباعته لأغراض تجارية إلا بعد الموافقة الخطية.
                    </p>

                    <!-- Icon-Only Social Share Bar -->
                    <div class="my-6 pt-5 border-t border-slate-100 text-center">
                        <span class="text-xs font-bold text-slate-400 block mb-3 tracking-wide">
                            مشاركة هذا الكتاب
                        </span>
                        
                        <div class="flex items-center justify-center gap-3">
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($book->title . ' - ' . request()->fullUrl()) }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               title="مشاركة عبر واتساب"
                               class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-100 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </a>

                            <!-- X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($book->title) }}&url={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               title="مشاركة عبر إكس"
                               class="w-10 h-10 rounded-full bg-slate-100 text-slate-800 hover:bg-black hover:text-white border border-slate-200 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               title="مشاركة عبر فيسبوك"
                               class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-100 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>

                            <!-- Telegram -->
                            <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($book->title) }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               title="مشاركة عبر تليجرام"
                               class="w-10 h-10 rounded-full bg-sky-50 text-sky-600 hover:bg-sky-500 hover:text-white border border-sky-100 flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.5 1.201-.82 1.23-.697.064-1.226-.461-1.901-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.911.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.831-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.321.023.465.141.119.098.152.228.166.331.016.115.011.237-.008.339z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- Universal Inline PDF Viewer -->
    <section id="reader" class="mx-auto max-w-[1360px] px-4 sm:px-6 lg:px-9">
        @if($book->pdf_path && $book->pdf_url)
            <div class="my-6 bg-slate-50 p-4 md:p-6 rounded-2xl border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base md:text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span>📖</span> تصفح الكتاب مباشرة
                    </h3>
                    <a href="{{ route('books.download', $book->id) }}" class="px-4 py-2 md:px-5 md:py-2.5 bg-[#1F5D43] text-white text-xs md:text-sm font-bold rounded-xl hover:bg-[#184C37] transition shadow-sm">
                        تحميل النسخة PDF
                    </a>
                </div>

                <!-- Universal Inline PDF Viewer -->
                <div class="w-full h-[550px] md:h-[750px] rounded-xl overflow-hidden border border-slate-200 bg-white shadow-inner">
                    @php
                        $pdfStreamUrl = route('books.stream', $book->id);
                        // If running on production HTTPS, use Google Docs viewer for guaranteed mobile inline rendering
                        $isProduction = config('app.env') === 'production';
                        $googleViewerUrl = 'https://docs.google.com/viewer?url=' . urlencode($pdfStreamUrl) . '&embedded=true';
                    @endphp

                    @if($isProduction)
                        <!-- Mobile Friendly Google Inline Viewer for Production -->
                        <iframe 
                            src="{{ $googleViewerUrl }}" 
                            class="w-full h-full border-0"
                            allowfullscreen>
                        </iframe>
                    @else
                        <!-- Direct Stream Viewer for Local Development -->
                        <iframe 
                            src="{{ $pdfStreamUrl }}#toolbar=1&navpanes=0" 
                            class="w-full h-full border-0"
                            type="application/pdf">
                        </iframe>
                    @endif
                </div>
            </div>
        @else
            <div class="p-12 text-center text-amber-800 bg-amber-50 rounded-xl border border-amber-200 font-medium my-6">
                ⚠️ ملف الـ PDF غير متاح حالياً أو لم يتم رفعه بشكل صحيح.
            </div>
        @endif
    </section>

    <!-- Related Books Section -->


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
