<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'مكتبة الشيخ فايز الزهراني' }}</title>
    <meta name="description" content="{{ $description ?? 'مكتبة رقمية مبسطة لعرض الكتب وقراءتها وتحميلها.' }}">

    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body {{ $attributes->merge(['class' => 'min-h-screen flex flex-col bg-background text-text-primary font-sans antialiased']) }}>
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-0 focus:right-1/2 focus:translate-x-1/2 focus:z-toast focus:px-space-16 focus:py-space-8 focus:bg-primary focus:text-white focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2">
        الانتقال إلى المحتوى الرئيسي
    </a>

    <header>
        {{ $header ?? '' }}
        @unless(isset($header))
            <x-navbar />
        @endunless
    </header>

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
