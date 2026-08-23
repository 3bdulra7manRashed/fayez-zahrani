<div>
    <!-- Hero Banner Component -->
    @include('partials.hero-banner')

    <!-- Search & Books Section -->
    <section class="max-w-7xl mx-auto px-4 my-8">
        <!-- Books Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
            @forelse($books as $book)
                <article wire:key="book-{{ $book->id }}" class="bg-white rounded-2xl border border-slate-100 shadow-2xs hover:shadow-md transition-all p-3 flex flex-col justify-between">
                    <div>
                        <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="block aspect-3/4 rounded-xl overflow-hidden bg-slate-50 mb-3">
                            @if(!empty($book->cover_path))
                                <img src="{{ asset('storage/' . $book->cover_path) }}" 
                                     alt="{{ $book->title }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="c{{ ($book->id % 8) + 1 }} flex aspect-3/4 items-center justify-center p-3 text-center text-xs font-bold leading-5 text-white">
                                    {{ $book->title }}
                                </div>
                            @endif
                        </a>
                        <h3 class="font-bold text-slate-800 text-sm text-center line-clamp-1 mb-3" title="{{ $book->title }}">
                            <a href="{{ route('book.show', $book->slug ?? $book->id) }}">{{ $book->title }}</a>
                        </h3>
                    </div>

                    <a href="{{ route('book.show', $book->slug ?? $book->id) }}" 
                       class="block w-full py-2 px-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold text-center rounded-xl transition border border-emerald-100/60">
                        عرض التفاصيل
                    </a>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-12 text-center text-slate-500">
                    لا توجد كتب مطابقة لبحثك.
                </div>
            @endforelse
        </div>

        @if(method_exists($books, 'links') && $books->hasPages())
            <div class="mt-8">
                {{ $books->links() }}
            </div>
        @endif
    </section>
</div>
