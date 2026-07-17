<?php

namespace App\Livewire;

use App\Mail\BookMessageNotification;
use App\Models\Book;
use App\Models\BookMessage;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class BookMessageForm extends Component
{
    use WithRateLimiting;

    public Book $book;
    public string $name = '';
    public string $email = '';
    public string $message = '';
    public string $honeypot = '';
    public string $successMessage = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
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
        try {
            $this->rateLimit(3, 60);
        } catch (TooManyRequestsException $exception) {
            $this->addError('message', 'لقد تجاوزت الحد المسموح به من المحاولات. يرجى الانتظار دقيقة قبل المحاولة مجددا.');
            return;
        }

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
        $this->message = '';
        $this->honeypot = '';
    }

    public function render()
    {
        return view('livewire.book-message-form');
    }
}
