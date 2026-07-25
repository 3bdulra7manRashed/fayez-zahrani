<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'لوحة التحكم - مكتبة فايز بن سعيد الزهراني' }}</title>
    <meta name="description" content="لوحة التحكم والتنظيم الرقمية لمكتبة الشيخ فايز الزهراني">

    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-background text-text-primary font-sans antialiased overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="h-screen flex overflow-hidden bg-background">
        <!-- Mobile Sidebar Overlay Backdrop -->
        <div x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-overlay bg-text-primary/40 backdrop-blur-xs lg:hidden"
            x-cloak></div>

        <!-- Sidebar Navigation Drawer -->
        <aside class="fixed inset-y-0 right-0 z-sticky w-72 h-screen bg-surface border-l border-border flex flex-col justify-between transform transition-transform duration-250 ease-in-out shrink-0 lg:translate-x-0 lg:static lg:z-auto"
            :class="sidebarOpen ? 'translate-x-0 shadow-modal' : 'translate-x-full lg:translate-x-0'">
            
            <!-- Top Section: Logo, Branding & Nav Links (Scrolls independently if needed) -->
            <div class="flex-1 flex flex-col min-h-0 overflow-y-auto">
                <!-- Sidebar Header / Branding -->
                <div class="h-20 px-6 border-b border-border flex items-center justify-between shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-lg shadow-card">
                            ف
                        </div>
                        <div>
                            <h2 class="text-heading-s text-text-primary leading-snug">لوحة التحكم</h2>
                            <p class="text-caption text-text-secondary">مكتبة الشيخ فايز الزهراني</p>
                        </div>
                    </a>

                    <!-- Mobile Close Button -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-text-secondary hover:text-primary focus:outline-none p-1 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5 flex-1">
                    <!-- Dashboard Link -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-body-small font-semibold transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white border-r-4 border-[#1F5D43] shadow-card font-bold' : 'text-text-secondary hover:text-primary hover:bg-primary/5' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>الإحصاءات الرئيسية</span>
                    </a>

                    <!-- Books Management Link -->
                    <a href="{{ route('admin.books.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-body-small font-semibold transition-all duration-150 {{ request()->routeIs('admin.books*') ? 'bg-primary text-white border-r-4 border-[#1F5D43] shadow-card font-bold' : 'text-text-secondary hover:text-primary hover:bg-primary/5' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>إدارة الكتب</span>
                    </a>

                    <!-- Messages Management Link -->
                    <a href="{{ route('admin.messages.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-body-small font-semibold transition-all duration-150 {{ request()->routeIs('admin.messages*') ? 'bg-primary text-white border-r-4 border-[#1F5D43] shadow-card font-bold' : 'text-text-secondary hover:text-primary hover:bg-primary/5' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>الرسائل الواردة</span>
                    </a>

                    <div class="border-t border-slate-100 my-4 pt-4">
                        <!-- Visit Public Site Link -->
                        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-between px-4 py-2.5 rounded-xl border border-slate-200 text-text-secondary hover:text-primary hover:border-primary/40 hover:bg-primary/5 text-body-small font-semibold transition-all duration-150 shadow-xs">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.6 9h16.8M3.6 15h16.8"/>
                                </svg>
                                <span>زيارة الموقع</span>
                            </div>
                            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Bottom Section: User Profile & Logout (Pinned to bottom) -->
            <div class="p-4 border-t border-border bg-background/50 shrink-0">
                <div class="flex items-center justify-between gap-3 mb-3 px-2">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-full bg-primary/10 border border-primary/20 text-primary flex items-center justify-center font-bold shrink-0">
                            {{ mb_substr(Auth::user()->name ?? 'أدمين', 0, 1) }}
                        </div>
                        <div class="truncate">
                            <p class="text-body-small font-bold text-text-primary truncate">{{ Auth::user()->name ?? 'مدير النظام' }}</p>
                            <p class="text-caption text-text-secondary truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Logout Form Button -->
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-danger/20 text-danger bg-danger/5 hover:bg-danger hover:text-white text-body-small font-semibold transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-danger/30 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area (Independent Scroll Container) -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            <!-- Topbar Header -->
            <header class="h-20 bg-surface border-b border-border flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger Menu Button -->
                    <button @click="sidebarOpen = true" class="lg:hidden text-text-primary hover:text-primary focus:outline-none p-2 rounded-lg border border-border bg-background">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Single Clear Page Title -->
                    <div>
                        <h1 class="text-heading-s sm:text-heading-m text-text-primary font-extrabold">
                            {{ $header ?? $title ?? 'لوحة التحكم' }}
                        </h1>
                    </div>
                </div>
            </header>

            <!-- Page Main Content Slot (Independent scroll viewport) -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
