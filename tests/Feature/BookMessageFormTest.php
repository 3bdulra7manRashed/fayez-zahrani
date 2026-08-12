<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookMessage;
use App\Livewire\BookMessageForm;
use App\Mail\BookMessageNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class BookMessageFormTest extends TestCase
{
    use RefreshDatabase;

    protected Book $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->book = Book::create([
            'title' => 'كتاب الرسائل',
            'slug' => 'message-book',
            'description' => 'وصف كتاب الرسائل',
            'cover_path' => 'books/cover.jpg',
            'pdf_path' => 'books/book.pdf',
        ]);
    }

    public function test_form_validates_required_fields()
    {
        Livewire::test(BookMessageForm::class, ['book' => $this->book])
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'message']);
    }

    public function test_form_validates_email_format()
    {
        Livewire::test(BookMessageForm::class, ['book' => $this->book])
            ->set('name', 'أحمد')
            ->set('email', 'not-an-email')
            ->set('message', 'رسالة طويلة كافية للمرور')
            ->call('submit')
            ->assertHasErrors(['email']);
    }

    public function test_form_validates_message_minimum_length()
    {
        Livewire::test(BookMessageForm::class, ['book' => $this->book])
            ->set('name', 'أحمد')
            ->set('email', 'test@example.com')
            ->set('message', 'قصيرة')
            ->call('submit')
            ->assertHasErrors(['message']);
    }

    public function test_successful_form_submission_saves_to_db_and_queues_email()
    {
        Mail::fake();

        Livewire::test(BookMessageForm::class, ['book' => $this->book])
            ->set('name', 'أحمد علي')
            ->set('email', 'ahmad@example.com')
            ->set('message', 'هذه رسالة استفسار ممتازة جداً من قارئ مهتم.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'تم إرسال رسالتك بنجاح! شكراً لتواصلك.');

        $this->assertDatabaseHas('book_messages', [
            'book_id' => $this->book->id,
            'name' => 'أحمد علي',
            'email' => 'ahmad@example.com',
            'message' => 'هذه رسالة استفسار ممتازة جداً من قارئ مهتم.',
        ]);

        Mail::assertQueued(BookMessageNotification::class);
    }

    public function test_honeypot_prevents_saving_but_shows_silent_success()
    {
        Mail::fake();

        Livewire::test(BookMessageForm::class, ['book' => $this->book])
            ->set('name', 'Bot Name')
            ->set('email', 'bot@example.com')
            ->set('message', 'Spam message that is long enough to bypass check.')
            ->set('honeypot', 'I am a bot')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'تم إرسال رسالتك بنجاح! شكراً لك.');

        // Verify it was NOT saved to the database
        $this->assertDatabaseMissing('book_messages', [
            'name' => 'Bot Name',
        ]);

        // Verify NO email was queued
        Mail::assertNotQueued(BookMessageNotification::class);
    }
}
