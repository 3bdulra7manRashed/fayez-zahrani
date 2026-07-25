<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-surface p-8 sm:p-10 rounded-2xl border border-border shadow-card animate-fade-up">
        <!-- Header -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 text-primary mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-heading-l text-text-primary">تسجيل الدخول للوحة التحكم</h2>
            <p class="text-body-small text-text-secondary">أدخل بيانات الاعتماد للوصول إلى لوحة إدارة المكتبة</p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="login" class="mt-8 space-y-6">
            @if ($errors->has('email') && !in_array($errors->first('email'), ['البريد الإلكتروني مطلوب.', 'يرجى إدخال بريد إلكتروني صحيح.']))
                <div class="p-4 rounded-lg bg-danger/10 border border-danger/20 text-danger text-body-small flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif

            <div class="space-y-4">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-body-small font-medium text-text-primary mb-2">
                        البريد الإلكتروني
                    </label>
                    <div class="relative">
                        <input wire:model="email" type="email" id="email" autocomplete="email" required
                            class="w-full px-4 py-3 rounded-lg border border-border bg-background text-text-primary text-body focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('email') border-danger @enderror"
                            placeholder="admin@example.com">
                    </div>
                    @error('email')
                        @if (in_array($message, ['البريد الإلكتروني مطلوب.', 'يرجى إدخال بريد إلكتروني صحيح.']))
                            <p class="mt-1 text-caption text-danger">{{ $message }}</p>
                        @endif
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-body-small font-medium text-text-primary mb-2">
                        كلمة المرور
                    </label>
                    <div class="relative">
                        <input wire:model="password" type="password" id="password" autocomplete="current-password" required
                            class="w-full px-4 py-3 rounded-lg border border-border bg-background text-text-primary text-body focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('password') border-danger @enderror"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-caption text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input wire:model="remember" type="checkbox"
                            class="w-4 h-4 rounded border-border text-primary focus:ring-primary/30 focus:ring-2">
                        <span class="text-body-small text-text-secondary">تذكرني على هذا الجهاز</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl text-body font-semibold text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-card transition-all disabled:opacity-50">
                    <span wire:loading.remove>تسجيل الدخول</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري التحقق...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
