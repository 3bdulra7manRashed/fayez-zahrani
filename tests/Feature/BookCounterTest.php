<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Livewire\BookShow;
use App\Livewire\DownloadButton;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BookCounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_views_increment_on_book_show_mount()
    {
        $book = Book::create([
            'title' => 'كتاب تجريبي',
            'slug' => 'test-book',
            'description' => 'هذا وصف تجريبي للكتاب.',
            'cover_path' => 'books/test.jpg',
            'pdf_path' => 'books/test.pdf',
            'views_count' => 5,
            'downloads_count' => 2,
        ]);

        $this->assertEquals(5, $book->views_count);

        // Mount BookShow component
        Livewire::test(BookShow::class, ['slug' => $book->slug]);

        $this->assertEquals(6, $book->fresh()->views_count);
    }

    public function test_downloads_increment_on_download_button_click()
    {
        $book = Book::create([
            'title' => 'كتاب تجريبي دوانلود',
            'slug' => 'test-download',
            'description' => 'هذا وصف تجريبي للتحميل.',
            'cover_path' => 'books/test.jpg',
            'pdf_path' => 'books/test.pdf',
            'views_count' => 10,
            'downloads_count' => 10,
        ]);

        $this->assertEquals(10, $book->downloads_count);

        // Trigger download action on DownloadButton component
        Livewire::test(DownloadButton::class, ['book' => $book])
            ->call('download');

        $this->assertEquals(11, $book->fresh()->downloads_count);
    }
}
