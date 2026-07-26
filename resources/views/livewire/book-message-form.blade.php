<div>
    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

    @if($successMessage)
        <div class="mb-4 rounded-lg border border-primary/20 bg-teal-tint p-4 text-center text-[14px] font-bold text-primary">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit="submit" class="grid gap-5">
        <div class="hidden" aria-hidden="true">
            <label for="honeypot_field">Do not fill this field</label>
            <input type="text" id="honeypot_field" wire:model="honeypot" tabindex="-1" autocomplete="off">
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label for="name" class="mb-1.5 block text-[13px] font-bold text-primary">الاسم *</label>
                <input type="text" id="name" wire:model="name" class="w-full rounded-lg border border-border bg-[#fbfcf8] px-4 py-3 text-[14px] text-text-primary outline-none transition focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary" placeholder="اكتب اسمك">
                @error('name')
                    <span class="mt-1 block text-[12px] font-medium text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-[13px] font-bold text-primary">البريد الإلكتروني *</label>
                <input type="email" id="email" wire:model="email" class="w-full rounded-lg border border-border bg-[#fbfcf8] px-4 py-3 text-left text-[14px] text-text-primary outline-none transition focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary" placeholder="example@domain.com">
                @error('email')
                    <span class="mt-1 block text-[12px] font-medium text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="phone_input" class="mb-1.5 block text-[13px] font-bold text-primary">رقم الجوال / الواتساب</label>
                <div class="relative dir-ltr" wire:ignore>
                    <input type="tel" id="phone_input" class="w-full rounded-lg border border-border bg-[#fbfcf8] px-4 py-3 text-left text-[14px] text-text-primary outline-none transition focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary" placeholder="50 123 4567">
                </div>
                <input type="hidden" wire:model="phone" id="phone_hidden">
                <input type="hidden" wire:model="country_code" id="country_code_hidden">
                @error('phone')
                    <span class="mt-1 block text-[12px] font-medium text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="message" class="mb-1.5 block text-[13px] font-bold text-primary">الرسالة *</label>
            <textarea id="message" wire:model="message" rows="5" class="w-full resize-y rounded-lg border border-border bg-[#fbfcf8] px-4 py-3 text-[14px] text-text-primary outline-none transition focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary" placeholder="اكتب ملاحظتك أو استفسارك حول هذا الكتاب..."></textarea>
            @error('message')
                <span class="mt-1 block text-[12px] font-medium text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-primary px-6 text-[14px] font-extrabold text-white transition hover:bg-primary-hover">
                إرسال الرسالة
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4" aria-hidden="true">
                    <path d="M22 2 11 13"/>
                    <path d="m22 2-7 20-4-9-9-4 20-7Z"/>
                </svg>
            </button>
        </div>
    </form>

    <!-- intl-tel-input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            initIntlTelInput();
        });
        document.addEventListener('livewire:navigated', () => {
            initIntlTelInput();
        });

        function initIntlTelInput() {
            const input = document.querySelector("#phone_input");
            if (input && !input.dataset.itiInitialized) {
                input.dataset.itiInitialized = "true";
                const iti = window.intlTelInput(input, {
                    initialCountry: "sa",
                    preferredCountries: ["sa", "eg", "ae", "kw", "qa", "bh", "om"],
                    separateDialCode: true,
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
                });

                const syncFields = () => {
                    const fullNum = iti.getNumber();
                    const rawVal = input.value.trim();
                    const valToSync = (fullNum && fullNum.length > 0) ? fullNum : rawVal;

                    const countryData = iti.getSelectedCountryData();
                    const dialCode = countryData && countryData.dialCode ? '+' + countryData.dialCode : '+966';

                    const hiddenPhone = document.querySelector("#phone_hidden");
                    const hiddenCountry = document.querySelector("#country_code_hidden");

                    if (hiddenPhone) {
                        hiddenPhone.value = valToSync;
                        hiddenPhone.dispatchEvent(new Event('input'));
                    }
                    if (hiddenCountry) {
                        hiddenCountry.value = dialCode;
                        hiddenCountry.dispatchEvent(new Event('input'));
                    }
                };

                input.addEventListener('change', syncFields);
                input.addEventListener('keyup', syncFields);
                input.addEventListener('countrychange', syncFields);

                const form = input.closest('form');
                if (form) {
                    form.addEventListener('submit', syncFields);
                }
            }
        }
    </script>
</div>
