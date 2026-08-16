<!-- Centered Text-Only Footer -->
<footer class="bg-white border-t border-slate-100 py-8 mt-16 text-center">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center justify-center gap-1 mb-3">
            <a href="{{ route('home') }}" class="inline-block">
                <h3 class="text-xl font-black text-slate-800 hover:text-[#1F5D43] transition">
                    مكتبة فايز الزهراني
                </h3>
            </a>
            <p class="text-xs text-slate-500 font-semibold tracking-wide">
                للقراءة والتحميل المباشر
            </p>
        </div>

        <div class="pt-4 border-t border-slate-100 max-w-xs mx-auto">
            <p class="text-xs text-slate-400 font-medium">
                &copy; {{ date('Y') }} جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</footer>
