<div class="space-y-8">
    <!-- Welcome Header Banner -->
    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-6 animate-fade-up">
        <div class="space-y-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-caption font-semibold bg-primary/10 text-primary border border-primary/20">
                مرحباً بعودتك 👋
            </span>
            <h1 class="text-heading-l sm:text-heading-xl text-text-primary font-extrabold">لوحة التحليلات والإحصاءات</h1>
            <p class="text-body text-text-secondary max-w-2xl">
                نظام إدارة ومتابعة كتب وإحصاءات ورسائل قراء مكتبة فايز بن سعيد الزهراني الرقمية.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.books.index') }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold shadow-card transition-all focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>إضافة كتاب جديد</span>
            </a>
        </div>
    </div>

    <!-- Top Stats Bar: Condensed & Sleek 4-Column Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Books & Pages -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-200 group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">إجمالي الكتب</span>
                <p class="text-heading-xl text-text-primary font-extrabold group-hover:text-primary transition-colors">
                    {{ number_format($stats['total_books']) }}
                </p>
                <span class="text-caption text-text-secondary block font-medium">
                    {{ number_format($stats['total_pages']) }} صفحة إجمالية
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                📚
            </div>
        </div>

        <!-- 2. Total Reads / Views -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-200 group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">إجمالي القراءات</span>
                <p class="text-heading-xl text-indigo-600 font-extrabold">
                    {{ number_format($stats['total_views']) }}
                </p>
                <span class="inline-flex items-center text-caption font-bold px-2 py-0.5 rounded bg-indigo-50 text-indigo-700">
                    مشاهدة مباشرة
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                👁️
            </div>
        </div>

        <!-- 3. Total Downloads -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-200 group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">إجمالي التحميلات</span>
                <p class="text-heading-xl text-emerald-600 font-extrabold">
                    {{ number_format($stats['total_downloads']) }}
                </p>
                <span class="inline-flex items-center text-caption font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">
                    تحميل PDF
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                📥
            </div>
        </div>

        <!-- 4. Total Messages & Unread -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-200 group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">الرسائل الواردة</span>
                <p class="text-heading-xl text-text-primary font-extrabold group-hover:text-primary transition-colors">
                    {{ number_format($stats['total_messages']) }}
                </p>
                @if ($stats['unread_messages'] > 0)
                    <span class="inline-flex items-center gap-1 text-caption font-bold px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200/60">
                        🔔 {{ $stats['unread_messages'] }} غير مقروءة
                    </span>
                @else
                    <span class="text-caption text-text-secondary block font-medium">
                        جميع الرسائل مقروءة
                    </span>
                @endif
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                ✉️
            </div>
        </div>
    </div>

    <!-- Asymmetric Main Content Grid (2/3 for Books, 1/3 for Messages) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Right Side: Recent Books Table (2/3 width) -->
        <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📚</span>
                    <h2 class="text-heading-s text-text-primary font-bold">أحدث الكتب المضافة</h2>
                </div>
                <a href="{{ route('admin.books.index') }}" class="text-caption font-bold text-primary hover:underline">
                    عرض جميع الكتب &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-text-secondary text-caption font-bold bg-slate-50/50">
                            <th class="py-3 px-4">الكتاب</th>
                            <th class="py-3 px-4">المشاهدات</th>
                            <th class="py-3 px-4">التحميلات</th>
                            <th class="py-3 px-4 text-center">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentBooks as $book)
                            <tr class="hover:bg-slate-50/80 transition-colors text-body-small">
                                <!-- Cover & Title/Publisher -->
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-14 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-200 shadow-xs">
                                            @if ($book->cover_path)
                                                <img src="{{ Storage::url($book->cover_path) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-xs text-text-secondary">📖</div>
                                            @endif
                                        </div>
                                        <div class="truncate max-w-xs">
                                            <h3 class="font-bold text-text-primary text-body-small truncate hover:text-primary transition-colors">
                                                <a href="{{ route('book.show', $book->slug) }}" target="_blank">{{ $book->title }}</a>
                                            </h3>
                                            <p class="text-caption text-text-secondary truncate mt-0.5">{{ $book->publisher ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Views Badge -->
                                <td class="py-3 px-4">
                                    <span class="text-caption font-bold px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700">
                                        👁️ {{ number_format($book->views_count) }}
                                    </span>
                                </td>

                                <!-- Downloads Badge -->
                                <td class="py-3 px-4">
                                    <span class="text-caption font-bold px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700">
                                        📥 {{ number_format($book->downloads_count) }}
                                    </span>
                                </td>

                                <!-- Quick Action -->
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('admin.books.index') }}"
                                        class="p-2 rounded-lg text-text-secondary hover:text-primary hover:bg-primary/10 transition-colors inline-block"
                                        title="إدارة الكتب">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 px-4 text-center text-text-secondary text-body-small font-medium space-y-2">
                                    <div class="text-3xl">📚</div>
                                    <p class="font-bold text-text-primary">لا يوجد كتب مضافة بعد</p>
                                    <p class="text-caption text-text-secondary">قم بإضافة كتابك الأول من قسم إدارة الكتب.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Left Side: Recent Messages Feed (1/3 width) -->
        <div class="lg:col-span-1 bg-white border border-slate-100 rounded-2xl shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">✉️</span>
                    <h2 class="text-heading-s text-text-primary font-bold">أحدث الرسائل</h2>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-caption font-bold text-primary hover:underline">
                    الكل &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($recentMessages as $msg)
                    <div class="p-3.5 rounded-xl border border-slate-100 hover:bg-slate-50/80 transition-colors space-y-2 {{ !$msg->is_read ? 'bg-primary/5 border-primary/20' : '' }}">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 truncate">
                                <strong class="text-body-small text-text-primary font-bold truncate">{{ $msg->name }}</strong>
                                @if (!$msg->is_read)
                                    <span class="px-2 py-0.5 rounded-full text-caption font-extrabold bg-danger text-white shrink-0">جديدة</span>
                                @endif
                            </div>
                            <span class="text-caption text-text-secondary shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-caption text-text-secondary truncate">
                            {{ Str::limit($msg->message, 60) }}
                        </p>

                        @if ($msg->book)
                            <div class="text-caption text-primary font-semibold truncate">
                                📖 {{ $msg->book->title }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-12 px-4 text-center text-text-secondary text-body-small font-medium space-y-2">
                        <div class="text-3xl">✉️</div>
                        <p class="font-bold text-text-primary">لا يوجد رسائل واردة بعد</p>
                        <p class="text-caption text-text-secondary">سيتم عرض رسائل القراء الزوار فور استقبالها.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
