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
        $relatedBooks = Book::query()
            ->where('id', '!=', $this->book->id)
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.book-show', [
            'relatedBooks' => $relatedBooks,
        ])
            ->layout('components.layouts.app')
            ->title($this->book->title . ' - مكتبة فايز الزهراني');
    }
}
