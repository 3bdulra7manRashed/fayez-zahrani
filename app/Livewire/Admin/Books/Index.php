<?php

namespace App\Livewire\Admin\Books;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('إدارة الكتب - لوحة التحكم')]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';

    // Modal State
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingBookId = null;
    public ?int $deletingBookId = null;

    // Form Fields
    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public string $edition = '';
    public string $publisher = '';
    public string $published_at = '';
    public string $pages_count = '';
    public string $dimensions = '';

    public $new_cover = null;
    public $new_pdf = null;
    public string $existing_cover_path = '';
    public string $existing_pdf_path = '';

    protected function rules(): array
    {
        $uniqueSlugRule = 'required|string|max:255|unique:books,slug' . ($this->editingBookId ? ',' . $this->editingBookId : '');

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => $uniqueSlugRule,
            'description' => 'required|string',
            'edition' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'pages_count' => 'nullable|integer|min:0',
            'dimensions' => 'nullable|string|max:255',
        ];

        if ($this->editingBookId) {
            $rules['new_cover'] = 'nullable|image|mimes:webp,jpg,jpeg,png|max:5120';
            $rules['new_pdf'] = 'nullable|mimes:pdf|max:51200';
        } else {
            $rules['new_cover'] = 'required|image|mimes:webp,jpg,jpeg,png|max:5120';
            $rules['new_pdf'] = 'required|mimes:pdf|max:51200';
        }

        return $rules;
    }

    protected array $messages = [
        'title.required' => 'عنوان الكتاب مطلوب.',
        'slug.required' => 'الرابط الثابت مطلوب.',
        'slug.unique' => 'هذا الرابط الثابت مستخدم بالفعل لكتاب آخر.',
        'description.required' => 'وصف الكتاب مطلوب.',
        'new_cover.required' => 'صورة غلاف الكتاب مطلوبة.',
        'new_cover.image' => 'يجب أن يكون الغلاف صورة صحيحة.',
        'new_cover.mimes' => 'يجب أن تكون صورة الغلاف بصيغة webp, jpg, jpeg, أو png.',
        'new_cover.max' => 'حجم صورة الغلاف يجب أن لا يتجاوز 5 ميجابايت.',
        'new_pdf.required' => 'ملف الكتاب (PDF) مطلوب.',
        'new_pdf.mimes' => 'يجب أن يكون الملف بصيغة PDF.',
        'new_pdf.max' => 'حجم ملف PDF يجب أن لا يتجاوز 50 ميجابايت.',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTitle(string $value): void
    {
        if (!$this->editingBookId || empty($this->slug)) {
            $this->slug = $this->generateSlug($value);
        }
    }

    private function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        if (empty($slug)) {
            $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', mb_strtolower(trim($title)));
            $slug = trim($slug, '-');
        }
        return $slug ?: 'book-' . time();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetForm();
        $book = Book::findOrFail($id);

        $this->editingBookId = $book->id;
        $this->title = $book->title;
        $this->slug = $book->slug;
        $this->description = $book->description;
        $this->edition = $book->edition ?? '';
        $this->publisher = $book->publisher ?? '';
        $this->published_at = $book->published_at ? $book->published_at->format('Y-m-d') : '';
        $this->pages_count = (string) $book->pages_count;
        $this->dimensions = $book->dimensions ?? '';
        $this->existing_cover_path = $book->cover_path;
        $this->existing_pdf_path = $book->pdf_path;

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingBookId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingBookId = null;
    }

    public function save(): void
    {
        if (empty($this->slug)) {
            $this->slug = $this->generateSlug($this->title);
        }

        $this->validate();

        if ($this->editingBookId) {
            $book = Book::findOrFail($this->editingBookId);

            $coverPath = $book->cover_path;
            if ($this->new_cover) {
                if ($book->cover_path && Storage::disk('public')->exists($book->cover_path)) {
                    Storage::disk('public')->delete($book->cover_path);
                }
                $coverPath = $this->new_cover->store('books', 'public');
            }

            $pdfPath = $book->pdf_path;
            if ($this->new_pdf) {
                if ($book->pdf_path && Storage::disk('public')->exists($book->pdf_path)) {
                    Storage::disk('public')->delete($book->pdf_path);
                }
                $pdfPath = $this->new_pdf->store('books', 'public');
            }

            $book->update([
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'edition' => $this->edition ?: null,
                'publisher' => $this->publisher ?: null,
                'published_at' => $this->published_at ?: null,
                'pages_count' => $this->pages_count !== '' ? (int) $this->pages_count : 0,
                'dimensions' => $this->dimensions ?: null,
                'cover_path' => $coverPath,
                'pdf_path' => $pdfPath,
            ]);

            session()->flash('message', 'تم تحديث بيانات الكتاب بنجاح.');
        } else {
            $coverPath = $this->new_cover->store('books', 'public');
            $pdfPath = $this->new_pdf->store('books', 'public');

            Book::create([
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'edition' => $this->edition ?: null,
                'publisher' => $this->publisher ?: null,
                'published_at' => $this->published_at ?: null,
                'pages_count' => $this->pages_count !== '' ? (int) $this->pages_count : 0,
                'dimensions' => $this->dimensions ?: null,
                'cover_path' => $coverPath,
                'pdf_path' => $pdfPath,
                'views_count' => 0,
                'downloads_count' => 0,
            ]);

            session()->flash('message', 'تم إضافة الكتاب الجديد بنجاح.');
        }

        $this->closeModal();
    }

    public function delete(): void
    {
        if (!$this->deletingBookId) {
            return;
        }

        $book = Book::findOrFail($this->deletingBookId);

        if ($book->cover_path && Storage::disk('public')->exists($book->cover_path)) {
            Storage::disk('public')->delete($book->cover_path);
        }

        if ($book->pdf_path && Storage::disk('public')->exists($book->pdf_path)) {
            Storage::disk('public')->delete($book->pdf_path);
        }

        $book->delete();

        session()->flash('message', 'تم حذف الكتاب بجميع ملفاته بنجاح.');
        $this->closeDeleteModal();
    }

    private function resetForm(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->editingBookId = null;
        $this->title = '';
        $this->slug = '';
        $this->description = '';
        $this->edition = '';
        $this->publisher = '';
        $this->published_at = '';
        $this->pages_count = '';
        $this->dimensions = '';
        $this->new_cover = null;
        $this->new_pdf = null;
        $this->existing_cover_path = '';
        $this->existing_pdf_path = '';
    }

    public function render()
    {
        $books = Book::query()
            ->when(trim($this->search) !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . trim($this->search) . '%')
                      ->orWhere('description', 'like', '%' . trim($this->search) . '%')
                      ->orWhere('publisher', 'like', '%' . trim($this->search) . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.books.index', [
            'books' => $books,
        ]);
    }
}
