<div class="bg-[#fbfcf8] pb-4 md:pb-6">
    <!-- Large Scale Hero Logo Image Block -->
    <section class="my-6 md:my-12 max-w-6xl mx-auto px-4 text-center">
        <a href="{{ route('home') }}" class="inline-block w-full">
            <img src="{{ asset('images/hero-logo.png') }}" 
                 alt="مكتبة الشيخ فايز بن سعيد الزهراني" 
                 class="w-full h-auto max-h-[480px] md:max-h-[600px] object-contain mx-auto block drop-shadow-xs">
        </a>

        <!-- Subtitle Line under Hero Banner -->
        <p class="text-xs md:text-sm text-slate-500 font-medium text-center mt-3 md:mt-4 tracking-wide">
            صفحة رسمية تفاعلية تجد فيها مؤلفات فايز الزهراني، ويمكنك من هنا قراءتها وتحميلها.
        </p>
    </section>

    <section id="books" class="mx-auto mt-6 max-w-[1400px] px-4 sm:px-6 lg:px-9">
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
                            <div class="mt-auto pt-3">
                                <a href="{{ route('book.show', $book->slug ?? $book->id) }}" 
                                   class="block w-full py-2.5 px-4 bg-emerald-50 hover:bg-emerald-100/80 text-emerald-800 text-xs md:text-sm font-bold text-center rounded-xl transition-all duration-200 border border-emerald-100/60 shadow-2xs">
                                    عرض التفاصيل
                                </a>
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
