<x-layouts.admin>
    <x-slot:title>إضافة كتاب جديد - لوحة التحكم</x-slot:title>
    <x-slot:header>إضافة كتاب جديد</x-slot:header>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Link & Title Header -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-2 text-body-small text-text-secondary hover:text-primary transition-colors font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                العودة لقائمة الكتب
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-surface border border-border rounded-2xl shadow-card p-6 sm:p-8 animate-fade-up">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-body-small font-medium text-text-primary mb-1.5">عنوان الكتاب *</label>
                        <input id="title" name="title" value="{{ old('title') }}" type="text" required
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary @error('title') border-danger @enderror"
                            placeholder="مثال: المعيار المربي والمنهج المبين">
                        @error('title') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-body-small font-medium text-text-primary mb-1.5">الرابط الثابت (Slug)</label>
                        <input id="slug" name="slug" value="{{ old('slug') }}" type="text"
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small font-mono focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary @error('slug') border-danger @enderror"
                            placeholder="يتم توليده تلقائياً إن ترك فارغاً">
                        @error('slug') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Edition -->
                    <div>
                        <label for="edition" class="block text-body-small font-medium text-text-primary mb-1.5">الطبعة</label>
                        <input id="edition" name="edition" value="{{ old('edition') }}" type="text"
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                            placeholder="مثال: الطبعة الأولى 1445هـ">
                    </div>

                    <!-- Publisher -->
                    <div>
                        <label for="publisher" class="block text-body-small font-medium text-text-primary mb-1.5">دار النشر</label>
                        <input id="publisher" name="publisher" value="{{ old('publisher') }}" type="text"
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                            placeholder="دار ابن الجوزي">
                    </div>

                    <!-- Published Date -->
                    <div>
                        <label for="published_at" class="block text-body-small font-medium text-text-primary mb-1.5">تاريخ النشر</label>
                        <input id="published_at" name="published_at" value="{{ old('published_at') }}" type="date"
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    </div>

                    <!-- Pages Count -->
                    <div>
                        <label for="pages_count" class="block text-body-small font-medium text-text-primary mb-1.5">عدد الصفحات</label>
                        <input id="pages_count" name="pages_count" value="{{ old('pages_count') }}" type="number" min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                            placeholder="240">
                    </div>

                    <!-- Dimensions -->
                    <div>
                        <label for="dimensions" class="block text-body-small font-medium text-text-primary mb-1.5">أبعاد الكتاب</label>
                        <input id="dimensions" name="dimensions" value="{{ old('dimensions') }}" type="text"
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                            placeholder="17 × 24 سم">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-body-small font-medium text-text-primary mb-1.5">وصف ونبذة عن الكتاب *</label>
                        <textarea id="description" name="description" rows="4" required
                            class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary @error('description') border-danger @enderror"
                            placeholder="اكتب نبذة مختصرة وملخصة عن موضوع الكتاب ومحتواه...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cover Image Upload -->
                    <div>
                        <label for="cover" class="block text-body-small font-medium text-text-primary mb-1.5">
                            صورة الغلاف * (مسموح: JPG, PNG, WEBP - حد أقصى 5MB)
                        </label>
                        <input id="cover" name="cover" type="file" accept="image/webp,image/jpeg,image/png,image/jpg" required
                            class="w-full px-3 py-2 rounded-xl border border-border bg-background text-text-primary text-caption file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-caption file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        @error('cover') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- PDF File Upload -->
                    <div>
                        <label for="pdf" class="block text-body-small font-medium text-text-primary mb-1.5">
                            ملف الكتاب PDF * (حد أقصى 100MB)
                        </label>
                        <input id="pdf" name="pdf" type="file" accept="application/pdf" required
                            class="w-full px-3 py-2 rounded-xl border border-border bg-background text-text-primary text-caption file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-caption file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        @error('pdf') <p class="mt-1 text-caption text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-border flex items-center justify-end gap-3">
                    <a href="{{ route('admin.books.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-border text-text-secondary hover:bg-background text-body-small font-semibold transition-colors focus:outline-none">
                        إلغاء
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold shadow-card transition-all focus:outline-none focus:ring-2 focus:ring-primary flex items-center gap-2">
                        <span>حفظ وإضافة الكتاب</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
