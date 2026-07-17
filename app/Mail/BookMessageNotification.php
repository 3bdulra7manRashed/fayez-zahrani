<?php

namespace App\Mail;

use App\Models\BookMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookMessageNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public BookMessage $bookMessage;

    public function __construct(BookMessage $bookMessage)
    {
        $this->bookMessage = $bookMessage->load('book');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'رسالة جديدة حول كتاب: ' . $this->bookMessage->book->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.book-message',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
