<?php

namespace Tests\Feature;

use App\Livewire\Admin\Books\Index;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminBookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_books_index_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.books.index'))
            ->assertStatus(200)
            ->assertSee('إدارة كتب المكتبة');
    }

    public function test_admin_can_create_a_book_with_cover_and_pdf_uploads(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $cover = UploadedFile::fake()->create('test_cover.jpg', 100, 'image/jpeg');
        $pdf = UploadedFile::fake()->create('test_book.pdf', 100, 'application/pdf');

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('openCreateModal')
            ->set('title', 'كتاب التجربة الفقهية')
            ->set('description', 'وصف شامل لكتاب التجربة الفقهية')
            ->set('pages_count', 180)
            ->set('publisher', 'دار ابن حزم')
            ->set('new_cover', $cover)
            ->set('new_pdf', $pdf)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('books', [
            'title' => 'كتاب التجربة الفقهية',
            'publisher' => 'دار ابن حزم',
            'pages_count' => 180,
        ]);

        $book = Book::where('title', 'كتاب التجربة الفقهية')->first();
        $this->assertNotNull($book);

        Storage::disk('public')->assertExists($book->cover_path);
        Storage::disk('public')->assertExists($book->pdf_path);
    }

    public function test_admin_can_update_a_book_and_replace_files(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $oldCover = UploadedFile::fake()->create('old_cover.jpg', 100, 'image/jpeg')->store('books', 'public');
        $oldPdf = UploadedFile::fake()->create('old_book.pdf', 100, 'application/pdf')->store('books', 'public');

        $book = Book::factory()->create([
            'title' => 'عنوان قديم',
            'cover_path' => $oldCover,
            'pdf_path' => $oldPdf,
        ]);

        $newCover = UploadedFile::fake()->create('new_cover.jpg', 100, 'image/jpeg');
        $newPdf = UploadedFile::fake()->create('new_book.pdf', 150, 'application/pdf');

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('openEditModal', $book->id)
            ->set('title', 'عنوان حديث ومعدل')
            ->set('new_cover', $newCover)
            ->set('new_pdf', $newPdf)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'عنوان حديث ومعدل',
        ]);

        $updatedBook = $book->fresh();
        Storage::disk('public')->assertMissing($oldCover);
        Storage::disk('public')->assertMissing($oldPdf);
        Storage::disk('public')->assertExists($updatedBook->cover_path);
        Storage::disk('public')->assertExists($updatedBook->pdf_path);
    }

    public function test_admin_can_delete_a_book_and_remove_files_from_storage(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $cover = UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg')->store('books', 'public');
        $pdf = UploadedFile::fake()->create('book.pdf', 100, 'application/pdf')->store('books', 'public');

        $book = Book::factory()->create([
            'cover_path' => $cover,
            'pdf_path' => $pdf,
        ]);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('confirmDelete', $book->id)
            ->call('delete')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);

        Storage::disk('public')->assertMissing($cover);
        Storage::disk('public')->assertMissing($pdf);
    }

    public function test_arabic_slug_generation(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(Index::class)
            ->set('title', 'كتاب الفقه الإسلامي وأدلته!');

        $this->assertEquals('كتاب-الفقه-الإسلامي-وأدلته', $component->get('slug'));
    }
}
