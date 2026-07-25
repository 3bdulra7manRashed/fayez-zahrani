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

    <!-- Header Card -->
    <div class="bg-surface border border-border p-6 rounded-2xl shadow-card flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-up">
        <div>
            <h1 class="text-heading-l text-text-primary">الرسائل الواردة</h1>
            <p class="text-body-small text-text-secondary mt-1">عرض ومتابعة رسائل وتواصل القراء والزوار حول كتب المكتبة</p>
        </div>

        @if ($unreadCount > 0)
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-danger/10 text-danger border border-danger/20 font-bold text-body-small shrink-0">
                <span class="w-2.5 h-2.5 rounded-full bg-danger animate-pulse"></span>
                لديك {{ $unreadCount }} رسالة جديدة غير مقروءة
            </span>
        @endif
    </div>

    <!-- Filter & Messages Table Card -->
    <div class="bg-surface border border-border rounded-2xl shadow-card overflow-hidden space-y-4">
        <!-- Filter Tabs & Search Bar -->
        <div class="p-4 border-b border-border bg-background/50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Filter Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
                <button wire:click="setFilter('all')"
                    class="px-4 py-2 rounded-xl text-body-small font-semibold transition-all duration-150 shrink-0 {{ $filter === 'all' ? 'bg-primary text-white shadow-card' : 'bg-surface text-text-secondary hover:text-primary hover:bg-background border border-border' }}">
                    الكل ({{ $totalCount }})
                </button>

                <button wire:click="setFilter('unread')"
                    class="px-4 py-2 rounded-xl text-body-small font-semibold transition-all duration-150 shrink-0 flex items-center gap-2 {{ $filter === 'unread' ? 'bg-primary text-white shadow-card' : 'bg-surface text-text-secondary hover:text-primary hover:bg-background border border-border' }}">
                    <span>غير مقروءة</span>
                    @if ($unreadCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-caption font-extrabold bg-danger text-white">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>

                <button wire:click="setFilter('read')"
                    class="px-4 py-2 rounded-xl text-body-small font-semibold transition-all duration-150 shrink-0 {{ $filter === 'read' ? 'bg-primary text-white shadow-card' : 'bg-surface text-text-secondary hover:text-primary hover:bg-background border border-border' }}">
                    مقروءة ({{ $readCount }})
                </button>
            </div>

            <!-- Search Bar -->
            <div class="relative flex-1 max-w-md">
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-border bg-surface text-text-primary text-body-small focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors"
                    placeholder="ابحث بالاسم، البريد، أو نص الرسالة...">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-text-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Messages Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="border-b border-border bg-background/70 text-text-secondary text-caption font-bold">
                        <th class="py-3.5 px-6">المرسل والبريد</th>
                        <th class="py-3.5 px-6">الكتاب المتعلق</th>
                        <th class="py-3.5 px-6">مقتطف من الرسالة</th>
                        <th class="py-3.5 px-6">تاريخ الإرسال</th>
                        <th class="py-3.5 px-6">الحالة</th>
                        <th class="py-3.5 px-6 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($messages as $msg)
                        <tr class="hover:bg-background/40 transition-colors text-body-small {{ !$msg->is_read ? 'bg-primary/5 font-semibold' : '' }}">
                            <!-- Sender Name & Email -->
                            <td class="py-4 px-6">
                                <div>
                                    <h3 class="font-bold text-text-primary text-body-small flex items-center gap-2">
                                        {{ $msg->name }}
                                        @if (!$msg->is_read)
                                            <span class="w-2 h-2 rounded-full bg-danger shrink-0"></span>
                                        @endif
                                    </h3>
                                    <a href="mailto:{{ $msg->email }}" class="text-caption text-text-secondary hover:text-primary transition-colors dir-ltr block text-right">
                                        {{ $msg->email }}
                                    </a>
                                </div>
                            </td>

                            <!-- Book Title -->
                            <td class="py-4 px-6 text-text-primary">
                                @if ($msg->book)
                                    <a href="{{ route('book.show', $msg->book->slug) }}" target="_blank" class="hover:text-primary font-medium transition-colors">
                                        📖 {{ $msg->book->title }}
                                    </a>
                                @else
                                    <span class="text-text-secondary text-caption">كتاب غير محدد</span>
                                @endif
                            </td>

                            <!-- Snippet -->
                            <td class="py-4 px-6 text-text-secondary max-w-xs truncate">
                                {{ Str::limit($msg->message, 70) }}
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-6 text-text-secondary text-caption">
                                <span title="{{ $msg->created_at->format('Y-m-d H:i') }}">
                                    {{ $msg->created_at->diffForHumans() }}
                                </span>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-6">
                                @if ($msg->is_read)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-caption font-bold bg-background text-text-secondary border border-border">
                                        مقروءة
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-caption font-bold bg-danger/10 text-danger border border-danger/20">
                                        جديدة
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openMessage({{ $msg->id }})"
                                        class="px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary text-primary hover:text-white text-caption font-bold transition-all focus:outline-none"
                                        title="عرض التفاصيل">
                                        عرض التفاصيل
                                    </button>

                                    <button wire:click="confirmDelete({{ $msg->id }})"
                                        class="p-2 rounded-lg text-text-secondary hover:text-danger hover:bg-danger/10 transition-colors focus:outline-none"
                                        title="حذف الرسالة">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-text-secondary">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="text-4xl">✉️</div>
                                    <h3 class="text-heading-s text-text-primary">لا يوجد رسائل للعرض</h3>
                                    <p class="text-caption text-text-secondary">لم يتم استقبال رسائل تطابق التصفية الحالية.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($messages->hasPages())
            <div class="p-4 border-t border-border bg-background/30">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- View Message Detail Modal -->
    @if ($showModal && $selectedMessage)
        <div class="fixed inset-0 z-modal flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-text-primary/50 backdrop-blur-xs transition-opacity" wire:click="closeModal"></div>

            <!-- Modal Window -->
            <div class="relative w-full max-w-2xl bg-surface border border-border rounded-2xl shadow-modal z-10 overflow-hidden my-8 animate-fade-up">
                <!-- Header -->
                <div class="p-6 border-b border-border flex items-center justify-between bg-background/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg">
                            ✉️
                        </div>
                        <div>
                            <h2 class="text-heading-s text-text-primary">تفاصيل الرسالة الواردة</h2>
                            <p class="text-caption text-text-secondary">{{ $selectedMessage->created_at->format('Y-m-d - h:i A') }}</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="text-text-secondary hover:text-text-primary text-xl font-bold focus:outline-none">&times;</button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <!-- Sender Info Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-border bg-background/50 space-y-1">
                            <span class="text-caption text-text-secondary block">اسم المرسل</span>
                            <strong class="text-body-small text-text-primary block">{{ $selectedMessage->name }}</strong>
                        </div>

                        <div class="p-4 rounded-xl border border-border bg-background/50 space-y-1">
                            <span class="text-caption text-text-secondary block">البريد الإلكتروني</span>
                            <a href="mailto:{{ $selectedMessage->email }}" class="text-body-small text-primary font-semibold hover:underline block dir-ltr text-right">
                                {{ $selectedMessage->email }}
                            </a>
                        </div>

                        @if ($selectedMessage->book)
                            <div class="p-4 rounded-xl border border-border bg-background/50 space-y-1 md:col-span-2">
                                <span class="text-caption text-text-secondary block">الكتاب المعني بالتواصل</span>
                                <a href="{{ route('book.show', $selectedMessage->book->slug) }}" target="_blank" class="text-body-small text-primary font-bold hover:underline inline-flex items-center gap-2">
                                    📖 {{ $selectedMessage->book->title }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Message Body -->
                    <div class="space-y-2">
                        <h4 class="text-body-small font-bold text-text-primary">محتوى الرسالة:</h4>
                        <div class="p-5 rounded-xl border border-border bg-background text-body text-text-primary leading-relaxed whitespace-pre-line">
                            {{ $selectedMessage->message }}
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-4 border-t border-border bg-background/50 flex items-center justify-between">
                    <button wire:click="confirmDelete({{ $selectedMessage->id }})"
                        class="px-4 py-2 rounded-xl text-danger hover:bg-danger/10 text-body-small font-semibold transition-colors focus:outline-none">
                        حذف هذه الرسالة
                    </button>

                    <button wire:click="closeModal"
                        class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-small font-semibold shadow-card transition-all focus:outline-none">
                        إغلاق
                    </button>
                </div>
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
                    <h3 class="text-heading-s text-text-primary">تأكيد حذف الرسالة</h3>
                    <p class="text-body-small text-text-secondary">هل أنت تأكد من رغبتك في حذف هذه الرسالة؟ لن يمكنك استعادتها مرة أخرى.</p>
                </div>

                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="closeDeleteModal"
                        class="px-5 py-2.5 rounded-xl border border-border text-text-secondary hover:bg-background text-body-small font-semibold transition-colors focus:outline-none">
                        إلغاء
                    </button>
                    <button wire:click="delete"
                        class="px-5 py-2.5 rounded-xl bg-danger hover:bg-danger/90 text-white text-body-small font-semibold shadow-card transition-all focus:outline-none focus:ring-2 focus:ring-danger">
                        حذف الرسالة الآن
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
