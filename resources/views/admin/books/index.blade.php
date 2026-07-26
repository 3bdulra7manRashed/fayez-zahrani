<x-layouts.admin>
    <x-slot:title>إدارة الكتب - لوحة التحكم</x-slot:title>
    <x-slot:header>إدارة كتب المكتبة</x-slot:header>

    <div class="space-y-6">
        <!-- Flash Message Notification -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="p-4 rounded-xl bg-success/10 border border-success/20 text-success text-body-small flex items-center justify-between shadow-card animate-fade-down">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('message') }}</span>
                </div>
                <button @click="show = false" class="text-success hover:text-success/80 font-bold text-lg focus:outline-none">&times;</button>
            </div>
        @endif

        <!-- Header Actions Card -->
        <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-up">
            <div>
                <h1 class="text-heading-l text-text-primary">إدارة كتب المكتبة</h1>
                <p class="text-body-small text-text-secondary mt-1">عرض وإضافة وتحديث كتب المكتبة الرقمية وقائمة الملفات</p>
            </div>

            <a href="{{ route('admin.books.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold shadow-card transition-all focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>إضافة كتاب جديد</span>
            </a>
        </div>

        <!-- Filter & Table Card -->
        <div class="bg-surface border border-border rounded-2xl shadow-card overflow-hidden space-y-4">
            <!-- Search Filter Toolbar -->
            <form action="{{ route('admin.books.index') }}" method="GET" class="p-4 border-b border-border bg-background/50 flex items-center gap-3">
                <div class="relative flex-1 max-w-md">
                    <input name="search" value="{{ $search }}" type="text"
                        class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-border bg-surface text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors"
                        placeholder="ابحث عن كتاب بالعنوان أو الوصف...">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-text-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold transition-colors">
                    بحث
                </button>
                @if ($search !== '')
                    <a href="{{ route('admin.books.index') }}" class="text-body-small text-text-secondary hover:text-danger focus:outline-none">
                        إلغاء البحث
                    </a>
                @endif
            </form>

            <!-- Books Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="border-b border-border bg-background/70 text-text-secondary text-caption font-bold">
                            <th class="py-3.5 px-6">الغلاف والكتاب</th>
                            <th class="py-3.5 px-6">الرابط الثابت</th>
                            <th class="py-3.5 px-6">الصفحات</th>
                            <th class="py-3.5 px-6">المشاهدات</th>
                            <th class="py-3.5 px-6">التحميلات</th>
                            <th class="py-3.5 px-6">تاريخ النشر</th>
                            <th class="py-3.5 px-6 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($books as $book)
                            <tr class="hover:bg-background/40 transition-colors text-body-small">
                                <!-- Cover & Title -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 rounded-lg bg-border/40 overflow-hidden shrink-0 border border-border shadow-xs">
                                            @if ($book->cover_path)
                                                <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-text-secondary">📚</div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-text-primary text-body-small hover:text-primary transition-colors">
                                                <a href="{{ route('book.show', $book->slug) }}" target="_blank">{{ $book->title }}</a>
                                            </h3>
                                            <p class="text-caption text-text-secondary truncate max-w-xs mt-0.5">{{ Str::limit($book->description, 60) }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Slug -->
                                <td class="py-4 px-6 text-text-secondary font-mono text-caption">
                                    {{ $book->slug }}
                                </td>

                                <!-- Pages Count -->
                                <td class="py-4 px-6 font-semibold text-text-primary">
                                    {{ $book->pages_count ? number_format($book->pages_count) : '-' }}
                                </td>

                                <!-- Views Count -->
                                <td class="py-4 px-6 text-text-primary font-semibold">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-primary/10 text-primary font-bold text-caption">
                                        👁️ {{ number_format($book->views_count) }}
                                    </span>
                                </td>

                                <!-- Downloads Count -->
                                <td class="py-4 px-6 text-text-primary font-semibold">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-accent/10 text-accent font-bold text-caption">
                                        📥 {{ number_format($book->downloads_count) }}
                                    </span>
                                </td>

                                <!-- Published At -->
                                <td class="py-4 px-6 text-text-secondary text-caption">
                                    {{ $book->published_at ? $book->published_at->format('Y-m-d') : 'غير محدد' }}
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.books.edit', $book->id) }}"
                                            class="p-2 rounded-lg text-text-secondary hover:text-primary hover:bg-primary/10 transition-colors focus:outline-none"
                                            title="تعديل الكتاب">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من رغبتك في حذف هذا الكتاب؟ سيتم إزالة كافة الملفات المرتبطة به بشكل نهائي.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-lg text-text-secondary hover:text-danger hover:bg-danger/10 transition-colors focus:outline-none"
                                                title="حذف الكتاب">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-text-secondary">
                                    <div class="max-w-sm mx-auto space-y-3">
                                        <div class="text-4xl">📚</div>
                                        <h3 class="text-heading-s text-text-primary">لا يوجد كتب للعرض</h3>
                                        <p class="text-caption text-text-secondary">لم يتم العثور على أي كتب تطابق البحث الحالي أو لم يتم إضافة كتب بعد.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($books->hasPages())
                <div class="p-4 border-t border-border bg-background/30">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
