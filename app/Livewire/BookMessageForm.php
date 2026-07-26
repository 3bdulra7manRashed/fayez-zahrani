<?php

namespace App\Livewire;

use App\Mail\BookMessageNotification;
use App\Models\Book;
use App\Models\BookMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class BookMessageForm extends Component
{

    public Book $book;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $country_code = '+966';
    public string $message = '';
    public string $honeypot = '';
    public string $successMessage = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'country_code' => 'nullable|string|max:10',
        'message' => 'required|string|min:10',
    ];

    protected array $messages = [
        'name.required' => 'يرجى إدخال اسمك.',
        'email.required' => 'يرجى إدخال بريدك الإلكتروني.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
        'message.required' => 'يرجى كتابة رسالتك.',
        'message.min' => 'يجب أن تكون الرسالة من 10 أحرف على الأقل.',
    ];

    public function submit(): void
    {
        $throttleKey = 'send-message:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $this->addError('message', 'لقد تجاوزت الحد المسموح به من المحاولات. يرجى الانتظار دقيقة قبل المحاولة مجددا.');
            return;
        }

        RateLimiter::hit($throttleKey, 60);

        if ($this->honeypot !== '') {
            $this->successMessage = 'تم إرسال رسالتك بنجاح! شكراً لك.';
            $this->resetForm();
            return;
        }

        // Sanitize phone input (Remove spaces, dashes, or non-digit chars before validation)
        if (!empty($this->phone)) {
            $this->phone = preg_replace('/[^0-9]/', '', $this->phone);
        }

        $countryCode = $this->country_code ?: '+966';

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|string|max:10',
            'phone' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($countryCode) {
                    if (empty($value)) return;

                    // Egypt (+20): 10 digits without leading zero OR 11 digits with zero
                    if ($countryCode === '+20' || $countryCode === '20') {
                        if (!preg_match('/^(01|1)[0-5][0-9]{8}$/', $value)) {
                            $fail('رقم الهاتف المصري غير صحيح (يجب أن يتكون من 10 أو 11 رقم ويبدأ بـ 01 أو 1).');
                        }
                    }
                    // Saudi Arabia (+966): 9 digits without zero OR 10 digits with zero
                    elseif ($countryCode === '+966' || $countryCode === '966') {
                        if (!preg_match('/^(05|5)[0-9]{8}$/', $value)) {
                            $fail('رقم الجوال السعودي غير صحيح (يجب أن يبدأ بـ 05 أو 5 ويتكون من 9 أو 10 أرقام).');
                        }
                    }
                    // Generic International Rule (8 to 14 digits)
                    else {
                        if (strlen($value) < 8 || strlen($value) > 14) {
                            $fail('رقم الهاتف غير صحيح.');
                        }
                    }
                },
            ],
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required' => 'يرجى كتابة الاسم.',
            'email.required' => 'يرجى كتابة البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'phone.numeric' => 'حقل رقم الجوال يجب أن يحتوي على أرقام فقط.',
            'message.required' => 'يرجى كتابة نص الرسالة.',
            'message.min' => 'يجب أن تكون الرسالة من 10 أحرف على الأقل.',
        ]);

        $bookMessage = BookMessage::create([
            'book_id' => $this->book->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'country_code' => $this->country_code ?: '+966',
            'message' => $this->message,
        ]);

        $ownerEmail = config('mail.owner_email') ?: config('mail.from.address');

        if ($ownerEmail) {
            Mail::to($ownerEmail)->queue(new BookMessageNotification($bookMessage));
        }

        $this->successMessage = 'تم إرسال رسالتك بنجاح! شكراً لتواصلك.';
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->country_code = '+966';
        $this->message = '';
        $this->honeypot = '';
    }

    public function render()
    {
        return view('livewire.book-message-form');
    }
}
