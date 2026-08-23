<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));

        $books = Book::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('publisher', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', [
            'books' => $books,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:books,slug',
            'description' => 'required|string',
            'edition' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'pages_count' => 'nullable|integer|min:0',
            'dimensions' => 'nullable|string|max:255',
            'cover' => 'required|file|image|mimes:jpg,jpeg,png,webp|max:5120',
            'pdf' => 'required|file|mimes:pdf|max:102400',
        ], [
            'title.required' => 'عنوان الكتاب مطلوب.',
            'slug.unique' => 'هذا الرابط الثابت مستخدم بالفعل لكتاب آخر.',
            'description.required' => 'وصف الكتاب مطلوب.',
            'cover.required' => 'صورة غلاف الكتاب مطلوبة.',
            'cover.image' => 'يجب أن يكون الغلاف صورة صحيحة.',
            'cover.mimes' => 'يجب أن تكون صورة الغلاف بصيغة webp, jpg, jpeg, أو png.',
            'cover.max' => 'حجم صورة الغلاف يجب أن لا يتجاوز 5 ميجابايت.',
            'pdf.required' => 'ملف الكتاب (PDF) مطلوب.',
            'pdf.mimes' => 'يجب أن يكون الملف بصيغة PDF.',
            'pdf.max' => 'حجم ملف PDF يجب أن لا يتجاوز 100 ميجابايت.',
        ]);

        $slug = !empty($validated['slug'])
            ? $validated['slug']
            : $this->generateTransliteratedSlug($validated['title']);

        $coverPath = $request->file('cover')->store('books/covers', 'public');
        $pdfPath = $request->file('pdf')->store('books/pdfs', 'public');

        Book::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'edition' => $validated['edition'] ?? null,
            'publisher' => $validated['publisher'] ?? null,
            'published_at' => $validated['published_at'] ?? null,
            'pages_count' => !empty($validated['pages_count']) ? (int) $validated['pages_count'] : 0,
            'dimensions' => $validated['dimensions'] ?? null,
            'cover_path' => $coverPath,
            'pdf_path' => $pdfPath,
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        return redirect()
            ->route('admin.books.index')
            ->with('message', 'تم إضافة الكتاب الجديد بنجاح.');
    }

    public function edit(Book $book): View
    {
        return view('admin.books.edit', [
            'book' => $book,
        ]);
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:books,slug,' . $book->id,
            'description' => 'required|string',
            'edition' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'pages_count' => 'nullable|integer|min:0',
            'dimensions' => 'nullable|string|max:255',
            'cover' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:5120',
            'pdf' => 'nullable|file|mimes:pdf|max:102400',
        ], [
            'title.required' => 'عنوان الكتاب مطلوب.',
            'slug.required' => 'الرابط الثابت مطلوب.',
            'slug.unique' => 'هذا الرابط الثابت مستخدم بالفعل لكتاب آخر.',
            'description.required' => 'وصف الكتاب مطلوب.',
            'cover.image' => 'يجب أن يكون الغلاف صورة صحيحة.',
            'cover.mimes' => 'يجب أن تكون صورة الغلاف بصيغة webp, jpg, jpeg, أو png.',
            'cover.max' => 'حجم صورة الغلاف يجب أن لا يتجاوز 5 ميجابايت.',
            'pdf.mimes' => 'يجب أن يكون الملف بصيغة PDF.',
            'pdf.max' => 'حجم ملف PDF يجب أن لا يتجاوز 100 ميجابايت.',
        ]);

        $coverPath = $book->cover_path;
        if ($request->hasFile('cover')) {
            if ($book->cover_path && Storage::disk('public')->exists($book->cover_path)) {
                Storage::disk('public')->delete($book->cover_path);
            }
            $coverPath = $request->file('cover')->store('books/covers', 'public');
        }

        $pdfPath = $book->pdf_path;
        if ($request->hasFile('pdf')) {
            if ($book->pdf_path && Storage::disk('public')->exists($book->pdf_path)) {
                Storage::disk('public')->delete($book->pdf_path);
            }
            $pdfPath = $request->file('pdf')->store('books/pdfs', 'public');
        }

        $slug = !empty($validated['slug'])
            ? $validated['slug']
            : $this->generateTransliteratedSlug($validated['title']);

        $book->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'edition' => $validated['edition'] ?? null,
            'publisher' => $validated['publisher'] ?? null,
            'published_at' => $validated['published_at'] ?? null,
            'pages_count' => isset($validated['pages_count']) && $validated['pages_count'] !== '' ? (int) $validated['pages_count'] : 0,
            'dimensions' => $validated['dimensions'] ?? null,
            'cover_path' => $coverPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.books.index')
            ->with('message', 'تم تحديث بيانات الكتاب بنجاح.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->cover_path && Storage::disk('public')->exists($book->cover_path)) {
            Storage::disk('public')->delete($book->cover_path);
        }

        if ($book->pdf_path && Storage::disk('public')->exists($book->pdf_path)) {
            Storage::disk('public')->delete($book->pdf_path);
        }

        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('message', 'تم حذف الكتاب بجميع ملفاته بنجاح.');
    }

    protected function generateTransliteratedSlug(string $title): string
    {
        $charMap = [
            'أ' => 'a', 'إ' => 'e', 'آ' => 'a', 'ا' => 'a', 'ب' => 'b', 'ت' => 't', 'ث' => 'th',
            'ج' => 'j', 'ح' => 'h', 'خ' => 'kh', 'د' => 'd', 'ذ' => 'th', 'ر' => 'r', 'ز' => 'z',
            'س' => 's', 'ش' => 'sh', 'ص' => 's', 'ض' => 'd', 'ط' => 't', 'ظ' => 'z', 'ع' => 'a',
            'غ' => 'gh', 'ف' => 'f', 'ق' => 'q', 'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
            'ه' => 'h', 'و' => 'w', 'ي' => 'y', 'ى' => 'a', 'ة' => 'h', 'ئ' => 'e', 'ؤ' => 'o', 'ء' => ''
        ];

        $transliterated = strtr($title, $charMap);
        $slug = \Illuminate\Support\Str::slug($transliterated, '-');

        if (empty($slug)) {
            $slug = \Illuminate\Support\Str::slug($title, '-', 'en');
        }

        return $slug ?: 'book-' . time();
    }
}
