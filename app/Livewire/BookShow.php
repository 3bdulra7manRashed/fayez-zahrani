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
        return view('livewire.book-show')
            ->layout('components.layouts.app')
            ->title($this->book->title . ' - مكتبة فايز الزهراني');
    }
}
