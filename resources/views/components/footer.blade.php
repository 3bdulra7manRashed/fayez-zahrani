<!-- Centered Minimalist Footer -->
<footer class="bg-white border-t border-slate-100 py-8 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="flex flex-col items-center justify-center gap-2 mb-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <h3 class="text-xl font-black text-slate-800 group-hover:text-[#1F5D43] transition">
                    مكتبة فايز الزهراني
                </h3>
                <div class="w-9 h-9 rounded-xl bg-[#1F5D43]/10 text-[#1F5D43] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </a>
            <p class="text-xs text-slate-500 font-semibold tracking-wide">
                للقراءة والتحميل المباشر
            </p>
        </div>

        <div class="pt-4 border-t border-slate-100 max-w-sm mx-auto">
            <p class="text-xs text-slate-400 font-medium">
                &copy; {{ date('Y') }} جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</footer>
