<div class="space-y-6">
    <!-- Success Flash Notification -->
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

        <button wire:click="openCreateModal"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold shadow-card transition-all focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>إضافة كتاب جديد</span>
        </button>
    </div>

    <!-- Filter & Table Card -->
    <div class="bg-surface border border-border rounded-2xl shadow-card overflow-hidden space-y-4">
        <!-- Search Filter Toolbar -->
        <div class="p-4 border-b border-border bg-background/50 flex items-center gap-3">
            <div class="relative flex-1 max-w-md">
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-border bg-surface text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors"
                    placeholder="ابحث عن كتاب بالعنوان أو الوصف...">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-text-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            @if ($search !== '')
                <button wire:click="$set('search', '')" class="text-body-small text-text-secondary hover:text-danger focus:outline-none">
                    إلغاء البحث
                </button>
            @endif
        </div>

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
                                            <img src="{{ Storage::url($book->cover_path) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
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
                                    <button wire:click="openEditModal({{ $book->id }})"
                                        class="p-2 rounded-lg text-text-secondary hover:text-primary hover:bg-primary/10 transition-colors focus:outline-none"
                                        title="تعديل الكتاب">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    <button wire:click="confirmDelete({{ $book->id }})"
                                        class="p-2 rounded-lg text-text-secondary hover:text-danger hover:bg-danger/10 transition-colors focus:outline-none"
                                        title="حذف الكتاب">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
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

    <!-- Create / Edit Book Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-modal flex items-center justify-center p-4 overflow-y-auto">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-text-primary/50 backdrop-blur-xs transition-opacity" wire:click="closeModal"></div>

            <!-- Modal Body -->
            <div class="relative w-full max-w-3xl bg-surface border border-border rounded-2xl shadow-modal z-10 overflow-hidden my-8 animate-fade-up">
                <!-- Modal Header -->
                <div class="p-6 border-b border-border flex items-center justify-between bg-background/50">
                    <h2 class="text-heading-m text-text-primary">
                        {{ $editingBookId ? 'تعديل بيانات الكتاب' : 'إضافة كتاب جديد' }}
                    </h2>
                    <button wire:click="closeModal" class="text-text-secondary hover:text-text-primary text-xl font-bold focus:outline-none">&times;</button>
                </div>

                <!-- Modal Form -->
                <form wire:submit.prevent="save" class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                    @if ($errors->any())
                        <div class="p-4 rounded-xl bg-danger/10 border border-danger/20 text-danger text-body-small">
                            <p class="font-bold mb-1">يرجى تصحيح الأخطاء التالية:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">عنوان الكتاب *</label>
                            <input wire:model.live="title" type="text"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary @error('title') border-danger @enderror"
                                placeholder="مثال: المعيار المربي والمنهج المبين">
                            @error('title') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">الرابط الثابت (Slug) *</label>
                            <input wire:model="slug" type="text"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small font-mono focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary @error('slug') border-danger @enderror"
                                placeholder="al-mueyar-al-murbi">
                            @error('slug') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Edition -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">الطبعة</label>
                            <input wire:model="edition" type="text"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                                placeholder="مثال: الطبعة الأولى 1445هـ">
                        </div>

                        <!-- Publisher -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">دار النشر</label>
                            <input wire:model="publisher" type="text"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                                placeholder="دار ابن الجوزي">
                        </div>

                        <!-- Published Date -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">تاريخ النشر</label>
                            <input wire:model="published_at" type="date"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>

                        <!-- Pages Count -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">عدد الصفحات</label>
                            <input wire:model="pages_count" type="number" min="0"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                                placeholder="240">
                        </div>

                        <!-- Dimensions -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">أبعاد الكتاب</label>
                            <input wire:model="dimensions" type="text"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                                placeholder="17 × 24 سم">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">وصف ونبذة عن الكتاب *</label>
                            <textarea wire:model="description" rows="4"
                                class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary @error('description') border-danger @enderror"
                                placeholder="اكتب نبذة مختصرة وملخصة عن موضوع الكتاب ومحتواه..."></textarea>
                            @error('description') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                        </div>

                        <!-- Cover Image Upload -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">
                                صورة الغلاف {{ $editingBookId ? '(اختياري للحدث)' : '*' }}
                            </label>
                            <input wire:model="new_cover" type="file" accept="image/webp,image/jpeg,image/png,image/jpg"
                                class="w-full px-3 py-2 rounded-xl border border-border bg-background text-text-primary text-caption file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-caption file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            @error('new_cover') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror

                            <!-- Preview Cover -->
                            <div class="mt-3">
                                @if ($new_cover)
                                    <span class="text-caption text-success font-semibold">تم اختيار صورة الغلاف: {{ $new_cover->getClientOriginalName() }}</span>
                                @elseif ($editingBookId && $existing_cover_path)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('storage/' . $existing_cover_path) }}" class="w-16 h-20 object-cover rounded-lg border border-border shadow-xs">
                                        <span class="text-caption text-text-secondary">الغلاف الحالي</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- PDF File Upload -->
                        <div>
                            <label class="block text-body-small font-medium text-text-primary mb-1.5">
                                ملف الكتاب (PDF) {{ $editingBookId ? '(اختياري للحدث)' : '*' }}
                            </label>
                            <input wire:model="new_pdf" type="file" accept="application/pdf"
                                class="w-full px-3 py-2 rounded-xl border border-border bg-background text-text-primary text-caption file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-caption file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            @error('new_pdf') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror

                            <div class="mt-3">
                                @if ($new_pdf)
                                    <span class="text-caption text-success font-semibold">تم اختيار ملف PDF جديد: {{ $new_pdf->getClientOriginalName() }}</span>
                                @elseif ($existing_pdf_path)
                                    <span class="text-caption text-text-secondary">الملف الحالي: {{ basename($existing_pdf_path) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                        <button type="button" wire:click="closeModal"
                            class="px-5 py-2.5 rounded-xl border border-border text-text-secondary hover:bg-background text-body-small font-semibold transition-colors focus:outline-none">
                            إلغاء
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save, new_cover, new_pdf"
                            class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold shadow-card transition-all focus:outline-none focus:ring-2 focus:ring-primary disabled:opacity-50 flex items-center gap-2">
                            <span wire:loading.remove wire:target="save, new_cover, new_pdf">حفظ بيانات الكتاب</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                جاري الحفظ...
                            </span>
                            <span wire:loading wire:target="new_cover, new_pdf" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                جاري رفع الملفات...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-modal flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-text-primary/50 backdrop-blur-xs transition-opacity" wire:click="closeDeleteModal"></div>

            <div class="relative w-full max-w-md bg-surface border border-border rounded-2xl shadow-modal z-10 p-6 space-y-6 text-center animate-fade-up">
                <div class="w-16 h-16 rounded-full bg-danger/10 text-danger flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>

                <div class="space-y-2">
                    <h3 class="text-heading-s text-text-primary">تأكيد حذف الكتاب</h3>
                    <p class="text-body-small text-text-secondary">هل أنت تأكد من رغبتك في حذف هذا الكتاب؟ سيتم إزالة كافة الملفات المرتبطة به بشكل نهائي.</p>
                </div>

                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="closeDeleteModal"
                        class="px-5 py-2.5 rounded-xl border border-border text-text-secondary hover:bg-background text-body-small font-semibold transition-colors focus:outline-none">
                        إلغاء
                    </button>
                    <button wire:click="delete"
                        class="px-5 py-2.5 rounded-xl bg-danger hover:bg-danger/90 text-white text-body-small font-semibold shadow-card transition-all focus:outline-none focus:ring-2 focus:ring-danger">
                        حذف الكتاب الآن
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
