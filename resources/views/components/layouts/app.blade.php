<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @php
        $defaultTitle = 'مكتبة الشيخ فايز بن سعيد الزهراني';
        $defaultDesc = 'صفحة رسمية تفاعلية تجد فيها مؤلفات الشيخ فايز بن سعيد الزهراني، للقراءة والتحميل المباشر.';
        $defaultImage = asset('images/hero-logo.png');
        
        $resolvedTitle = View::hasSection('title') ? View::yieldContent('title') : ($title ?? $defaultTitle);
        $resolvedDesc = View::hasSection('meta_description') 
            ? View::yieldContent('meta_description') 
            : (View::hasSection('description') 
                ? View::yieldContent('description') 
                : ($meta_description ?? $description ?? $defaultDesc));
        $resolvedOgTitle = View::hasSection('og_title') ? View::yieldContent('og_title') : ($og_title ?? $resolvedTitle);
        $resolvedOgDesc = View::hasSection('og_description') ? View::yieldContent('og_description') : ($og_description ?? $resolvedDesc);
        $resolvedOgImage = View::hasSection('og_image') ? View::yieldContent('og_image') : ($og_image ?? $defaultImage);
        $resolvedOgType = View::hasSection('og_type') ? View::yieldContent('og_type') : ($og_type ?? 'website');
        $resolvedCanonical = View::hasSection('canonical_url') ? View::yieldContent('canonical_url') : ($canonical_url ?? request()->url());
    @endphp

    <title>{{ $resolvedTitle }}</title>
    <meta name="description" content="{{ $resolvedDesc }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $resolvedCanonical }}">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="{{ $resolvedOgType }}">
    <meta property="og:site_name" content="مكتبة الشيخ فايز بن سعيد الزهراني">
    <meta property="og:title" content="{{ $resolvedOgTitle }}">
    <meta property="og:description" content="{{ $resolvedOgDesc }}">
    <meta property="og:image" content="{{ $resolvedOgImage }}">
    <meta property="og:image:secure_url" content="{{ $resolvedOgImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ $resolvedCanonical }}">
    <meta property="og:locale" content="ar_AR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $resolvedOgTitle }}">
    <meta name="twitter:description" content="{{ $resolvedOgDesc }}">
    <meta name="twitter:image" content="{{ $resolvedOgImage }}">

    <!-- Dynamic Schema.org JSON-LD -->
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
