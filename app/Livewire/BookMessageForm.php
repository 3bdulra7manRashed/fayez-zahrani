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

        $this->validate();

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
