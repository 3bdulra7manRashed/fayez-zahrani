<div class="space-y-8">
    <!-- Welcome Header Card -->
    <div class="bg-surface border border-border p-6 sm:p-8 rounded-2xl shadow-card flex flex-col md:flex-row md:items-center md:justify-between gap-6 animate-fade-up">
        <div class="space-y-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-caption font-semibold bg-primary/10 text-primary border border-primary/20">
                مرحباً بعودتك 👋
            </span>
            <h1 class="text-heading-l sm:text-heading-xl text-text-primary">لوحة التحليلات والإحصاءات</h1>
            <p class="text-body text-text-secondary max-w-2xl">
                نظام إدارة ومتابعة كتب وإحصاءات ورسائل قراء مكتبة الشيخ فايز بن سعيد الزهراني الرقمية.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.books.index') }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold shadow-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>إضافة كتاب جديد</span>
            </a>
        </div>
    </div>

    <!-- Analytics Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Books Card -->
        <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex items-center justify-between hover:border-primary/30 transition-all group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">إجمالي الكتب الرقمية</span>
                <p class="text-heading-xl text-text-primary group-hover:text-primary transition-colors">
                    {{ number_format($stats['total_books']) }}
                </p>
                <span class="text-caption text-text-secondary block">كتاب متاح في المكتبة</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                📚
            </div>
        </div>

        <!-- Total Views Card -->
        <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex items-center justify-between hover:border-primary/30 transition-all group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">إجمالي قراءات الكتب</span>
                <p class="text-heading-xl text-primary">
                    {{ number_format($stats['total_views']) }}
                </p>
                <span class="text-caption text-text-secondary block">مشاهدة مباشرة للكتب</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                👁️
            </div>
        </div>

        <!-- Total Downloads Card -->
        <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex items-center justify-between hover:border-accent/30 transition-all group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">إجمالي عمليات التحميل</span>
                <p class="text-heading-xl text-accent">
                    {{ number_format($stats['total_downloads']) }}
                </p>
                <span class="text-caption text-text-secondary block">تحميل ملفات PDF</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-accent/10 text-accent flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                📥
            </div>
        </div>

        <!-- Total Messages Card -->
        <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex items-center justify-between hover:border-primary/30 transition-all group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">إجمالي الرسائل الواردة</span>
                <p class="text-heading-xl text-text-primary group-hover:text-primary transition-colors">
                    {{ number_format($stats['total_messages']) }}
                </p>
                <span class="text-caption text-text-secondary block">رسالة تواصل من القراء</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                ✉️
            </div>
        </div>

        <!-- Unread Messages Card -->
        <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex items-center justify-between transition-all group {{ $stats['unread_messages'] > 0 ? 'border-danger/30 bg-danger/5' : '' }}">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">الرسائل غير المقروءة</span>
                <p class="text-heading-xl {{ $stats['unread_messages'] > 0 ? 'text-danger' : 'text-text-primary' }}">
                    {{ number_format($stats['unread_messages']) }}
                </p>
                <span class="text-caption text-text-secondary block">تتطلب المراجعة</span>
            </div>
            <div class="w-14 h-14 rounded-2xl {{ $stats['unread_messages'] > 0 ? 'bg-danger/10 text-danger' : 'bg-background text-text-secondary' }} flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                🔔
            </div>
        </div>

        <!-- Total Pages Card -->
        <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex items-center justify-between hover:border-primary/30 transition-all group">
            <div class="space-y-1">
                <span class="text-caption font-bold text-text-secondary">مجموع صفحات الكتب</span>
                <p class="text-heading-xl text-text-primary group-hover:text-primary transition-colors">
                    {{ number_format($stats['total_pages']) }}
                </p>
                <span class="text-caption text-text-secondary block">صفحة في كتب المكتبة</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                📄
            </div>
        </div>
    </div>

    <!-- Recent Activity Tables Two-Column Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Books Column -->
        <div class="bg-surface border border-border rounded-2xl shadow-card p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-border pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📚</span>
                    <h2 class="text-heading-s text-text-primary">أحدث الكتب المضافة</h2>
                </div>
                <a href="{{ route('admin.books.index') }}" class="text-caption font-bold text-primary hover:underline">
                    عرض جميع الكتب &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($recentBooks as $book)
                    <div class="p-3 rounded-xl border border-border hover:bg-background/60 transition-colors flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-10 h-14 rounded-lg bg-border/40 overflow-hidden shrink-0 border border-border">
                                @if ($book->cover_path)
                                    <img src="{{ Storage::url($book->cover_path) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs">📖</div>
                                @endif
                            </div>
                            <div class="truncate">
                                <h3 class="font-bold text-text-primary text-body-small truncate hover:text-primary">
                                    <a href="{{ route('book.show', $book->slug) }}" target="_blank">{{ $book->title }}</a>
                                </h3>
                                <p class="text-caption text-text-secondary truncate mt-0.5">{{ $book->publisher ?? 'غير محدد' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-caption font-bold px-2 py-1 rounded-md bg-primary/10 text-primary">
                                👁️ {{ number_format($book->views_count) }}
                            </span>
                            <span class="text-caption font-bold px-2 py-1 rounded-md bg-accent/10 text-accent">
                                📥 {{ number_format($book->downloads_count) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-text-secondary text-body-small">
                        لا يوجد كتب مضافة بعد.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Messages Column -->
        <div class="bg-surface border border-border rounded-2xl shadow-card p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-border pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">✉️</span>
                    <h2 class="text-heading-s text-text-primary">أحدث الرسائل الواردة</h2>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-caption font-bold text-primary hover:underline">
                    عرض جميع الرسائل &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($recentMessages as $msg)
                    <div class="p-3.5 rounded-xl border border-border hover:bg-background/60 transition-colors space-y-2 {{ !$msg->is_read ? 'bg-primary/5 border-primary/20' : '' }}">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <strong class="text-body-small text-text-primary">{{ $msg->name }}</strong>
                                @if (!$msg->is_read)
                                    <span class="px-2 py-0.5 rounded-full text-caption font-extrabold bg-danger text-white">جديدة</span>
                                @endif
                            </div>
                            <span class="text-caption text-text-secondary">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-caption text-text-secondary truncate">
                            {{ Str::limit($msg->message, 80) }}
                        </p>

                        @if ($msg->book)
                            <div class="text-caption text-primary font-semibold">
                                📖 {{ $msg->book->title }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center text-text-secondary text-body-small">
                        لا يوجد رسائل واردة بعد.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
