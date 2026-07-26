<?php

namespace Tests\Feature;

use App\Livewire\BookShow;
use App\Livewire\DownloadButton;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PdfViewerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pdf_url_attribute_returns_correct_asset_url_when_path_is_set(): void
    {
        $book = Book::factory()->create([
            'pdf_path' => 'books/sample.pdf',
        ]);

        $this->assertStringContainsString('storage/books/sample.pdf', $book->pdf_url);
    }

    public function test_pdf_url_attribute_returns_empty_string_when_path_is_null(): void
    {
        $book = Book::factory()->create([
            'pdf_path' => null,
        ]);

        $this->assertEquals('', $book->pdf_url);
    }

    public function test_book_show_page_renders_pdf_viewer_when_pdf_exists(): void
    {
        $book = Book::factory()->create([
            'title' => 'كتاب اختبار المعاينة',
            'slug' => 'test-pdf-view',
            'pdf_path' => 'books/test.pdf',
        ]);

        $this->get(route('book.show', $book->slug))
            ->assertStatus(200)
            ->assertSee('تصفح الكتاب مباشرة', false)
            ->assertSee('/storage/' . $book->pdf_path, false);
    }

    public function test_book_show_page_renders_fallback_when_no_pdf(): void
    {
        $book = Book::factory()->create([
            'title' => 'كتاب بدون ملف',
            'slug' => 'book-without-pdf',
            'pdf_path' => null,
        ]);

        Livewire::test(BookShow::class, ['slug' => $book->slug])
            ->assertSee('ملف الـ PDF غير متاح حالياً');
    }

    public function test_download_route_returns_pdf_file(): void
    {
        Storage::fake('public');

        $pdfFile = UploadedFile::fake()->create('sample.pdf', 50, 'application/pdf');
        $storedPath = $pdfFile->store('books', 'public');

        $book = Book::factory()->create([
            'title' => 'كتاب التحميل',
            'pdf_path' => $storedPath,
        ]);

        $response = $this->get(route('books.download', $book->id));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_download_route_returns_404_when_pdf_file_missing(): void
    {
        Storage::fake('public');

        $book = Book::factory()->create([
            'pdf_path' => 'books/non_existent.pdf',
        ]);

        $response = $this->get(route('books.download', $book->id));

        $response->assertStatus(404);
    }

    public function test_download_button_increments_count_and_redirects_to_download_route(): void
    {
        Storage::fake('public');

        $pdfFile = UploadedFile::fake()->create('sample.pdf', 50, 'application/pdf');
        $storedPath = $pdfFile->store('books', 'public');

        $book = Book::factory()->create([
            'pdf_path' => $storedPath,
            'downloads_count' => 5,
        ]);

        Livewire::test(DownloadButton::class, ['book' => $book])
            ->call('download')
            ->assertRedirect(route('books.download', $book->id));

        $this->assertEquals(6, $book->fresh()->downloads_count);
    }

    public function test_stream_pdf_route_returns_inline_pdf(): void
    {
        Storage::fake('public');

        $pdfFile = UploadedFile::fake()->create('sample.pdf', 50, 'application/pdf');
        $storedPath = $pdfFile->store('books', 'public');

        $book = Book::factory()->create([
            'title' => 'كتاب المعاينة المباشرة',
            'pdf_path' => $storedPath,
        ]);

        $response = $this->get(route('books.stream', $book->id));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertHeader('content-disposition');
        $this->assertStringContainsString('inline', $response->headers->get('content-disposition'));
    }

    public function test_stream_pdf_route_returns_404_when_no_pdf(): void
    {
        Storage::fake('public');

        $book = Book::factory()->create([
            'pdf_path' => 'books/missing.pdf',
        ]);

        $this->get(route('books.stream', $book->id))
            ->assertStatus(404);
    }
}
