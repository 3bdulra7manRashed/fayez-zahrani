<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $title ?? 'مكتبة فايز بن سعيد الزهراني')</title>
    <meta name="description" content="@yield('meta_description', $meta_description ?? $description ?? 'صفحة رسمية تفاعلية تجد فيها مؤلفات فايز بن سعيد الزهراني، للقراءة والتحميل المباشر.')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical_url', $canonical_url ?? url()->current())">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="@yield('og_type', $og_type ?? 'website')">
    <meta property="og:site_name" content="مكتبة فايز بن سعيد الزهراني">
    <meta property="og:title" content="@yield('og_title', $og_title ?? $title ?? 'مكتبة فايز بن سعيد الزهراني')">
    <meta property="og:description" content="@yield('og_description', $og_description ?? $meta_description ?? $description ?? 'صفحة رسمية تفاعلية تجد فيها مؤلفات فايز بن سعيد الزهراني، للقراءة والتحميل المباشر.')">
    <meta property="og:image" content="@yield('og_image', $og_image ?? asset('images/hero-logo.png'))">
    <meta property="og:url" content="@yield('canonical_url', $canonical_url ?? url()->current())">
    <meta property="og:locale" content="ar_AR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $og_title ?? $title ?? 'مكتبة فايز بن سعيد الزهراني')">
    <meta name="twitter:description" content="@yield('og_description', $og_description ?? $meta_description ?? $description ?? 'صفحة رسمية تفاعلية تجد فيها مؤلفات فايز بن سعيد الزهراني، للقراءة والتحميل المباشر.')">
    <meta name="twitter:image" content="@yield('og_image', $og_image ?? asset('images/hero-logo.png'))">

    @yield('structured_data')
    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body {{ $attributes->merge(['class' => 'min-h-screen flex flex-col bg-background text-text-primary font-sans antialiased']) }}>
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-0 focus:right-1/2 focus:translate-x-1/2 focus:z-toast focus:px-space-16 focus:py-space-8 focus:bg-primary focus:text-white focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2">
        الانتقال إلى المحتوى الرئيسي
    </a>

    <main id="main-content" tabindex="-1" class="focus:outline-none flex-1">
        {{ $slot }}
    </main>

    @if(isset($footer))
        {{ $footer }}
    @else
        <x-footer />
    @endif

    @stack('scripts')
</body>
</html>
