<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookShow extends Component
{
    public Book $book;

    public function mount(string $slug): void
    {
        $this->book = Book::where('slug', $slug)->firstOrFail();
        $this->book->increment('views_count');
        $this->book->refresh();
    }

    public function render()
    {
        $cleanDescription = $this->book->description 
            ? \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($this->book->description))), 160)
            : 'تصفح وقراءة وتحميل كتاب ' . $this->book->title . ' مباشرة من مكتبة الشيخ فايز بن سعيد الزهراني.';

        $coverUrl = $this->book->cover_path 
            ? asset('storage/' . $this->book->cover_path) 
            : asset('images/hero-logo.png');

        return view('livewire.book-show', [
            'cleanDescription' => $cleanDescription,
            'coverUrl' => $coverUrl,
        ])
            ->layout('components.layouts.app', [
                'title' => $this->book->title . ' - مكتبة الشيخ فايز بن سعيد الزهراني',
                'description' => $cleanDescription,
                'meta_description' => $cleanDescription,
                'og_title' => $this->book->title . ' - مكتبة الشيخ فايز بن سعيد الزهراني',
                'og_description' => $cleanDescription,
                'og_image' => $coverUrl,
                'og_type' => 'book',
                'canonical_url' => request()->url(),
            ])
            ->title($this->book->title . ' - مكتبة الشيخ فايز بن سعيد الزهراني');
    }
}
