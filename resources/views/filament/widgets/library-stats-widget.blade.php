<x-filament-widgets::widget>
    <div class="flex flex-col gap-6" dir="rtl">
        <!-- Stats Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Views -->
            <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary-50 text-primary-600 rounded-lg dark:bg-primary-500/10 dark:text-primary-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">إجمالي مشاهدات الكتب</div>
                        <div class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white mt-1">
                            {{ number_format($totalViews) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Downloads -->
            <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-success-50 text-success-600 rounded-lg dark:bg-success-500/10 dark:text-success-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">إجمالي التحميلات</div>
                        <div class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white mt-1">
                            {{ number_format($totalDownloads) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unread Messages -->
            <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-warning-50 text-warning-600 rounded-lg dark:bg-warning-500/10 dark:text-warning-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v4h16z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">الرسائل غير المقروءة</div>
                        <div class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white mt-1">
                            {{ $unreadMessages }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Messages Table -->
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/10">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">أحدث الرسائل الواردة</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400 font-semibold border-b border-gray-100 dark:border-white/10">
                            <th class="px-6 py-3">اسم المرسل</th>
                            <th class="px-6 py-3">الكتاب المرتبط</th>
                            <th class="px-6 py-3">نص الرسالة</th>
                            <th class="px-6 py-3">الحالة</th>
                            <th class="px-6 py-3">تاريخ الإرسال</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($recentMessages as $msg)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $msg->name }}
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $msg->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $msg->book->title }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300 max-w-xs truncate" title="{{ $msg->message }}">
                                    {{ Str::limit($msg->message, 80) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($msg->is_read)
                                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20">مقروءة</span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-warning-50 px-2 py-1 text-xs font-medium text-warning-800 ring-1 ring-inset ring-warning-650/10 dark:bg-warning-400/10 dark:text-warning-400 dark:ring-warning-450/20">جديدة</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $msg->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    لا توجد رسائل واردة حالياً.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
