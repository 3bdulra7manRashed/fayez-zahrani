<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_admin_can_view_create_book_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.books.create'))
            ->assertStatus(200)
            ->assertSee('إضافة كتاب جديد');
    }

    public function test_admin_can_create_a_book_with_cover_and_pdf_uploads(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $cover = UploadedFile::fake()->create('test_cover.jpg', 100, 'image/jpeg');
        $pdf = UploadedFile::fake()->create('test_book.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)
            ->post(route('admin.books.store'), [
                'title' => 'كتاب التجربة الفقهية',
                'description' => 'وصف شامل لكتاب التجربة الفقهية',
                'pages_count' => 180,
                'publisher' => 'دار ابن حزم',
                'cover' => $cover,
                'pdf' => $pdf,
            ]);

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('message');

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

    public function test_admin_can_view_edit_book_page(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.books.edit', $book->id))
            ->assertStatus(200)
            ->assertSee('تعديل بيانات الكتاب');
    }

    public function test_admin_can_update_a_book_and_replace_files(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $oldCover = UploadedFile::fake()->create('old_cover.jpg', 100, 'image/jpeg')->store('books', 'public');
        $oldPdf = UploadedFile::fake()->create('old_book.pdf', 100, 'application/pdf')->store('books', 'public');

        $book = Book::factory()->create([
            'title' => 'عنوان قديم',
            'slug' => 'old-slug',
            'cover_path' => $oldCover,
            'pdf_path' => $oldPdf,
        ]);

        $newCover = UploadedFile::fake()->create('new_cover.jpg', 100, 'image/jpeg');
        $newPdf = UploadedFile::fake()->create('new_book.pdf', 150, 'application/pdf');

        $response = $this->actingAs($user)
            ->put(route('admin.books.update', $book->id), [
                'title' => 'عنوان حديث ومعدل',
                'slug' => 'old-slug',
                'description' => 'وصف معدل لكتاب قديم',
                'cover' => $newCover,
                'pdf' => $newPdf,
            ]);

        $response->assertRedirect(route('admin.books.index'));

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

        $response = $this->actingAs($user)
            ->delete(route('admin.books.destroy', $book->id));

        $response->assertRedirect(route('admin.books.index'));

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);

        Storage::disk('public')->assertMissing($cover);
        Storage::disk('public')->assertMissing($pdf);
    }
}
