<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\On;
use Livewire\Component;

class HomePage extends Component
{
    public string $search = '';

    #[On('search-updated')]
    public function updateSearch(string $search): void
    {
        $this->search = $search;
    }

    public function render()
    {
        $stats = [
            'total_pages' => Book::sum('pages_count'),
            'total_views' => Book::sum('views_count'),
            'total_downloads' => Book::sum('downloads_count'),
            'total_books' => Book::count(),
            'latest_update' => Book::latest('updated_at')->first()?->updated_at,
        ];

        $books = Book::query()
            ->when(trim($this->search) !== '', function ($query) {
                $query->where(function ($query) {
                    $query
                        ->where('title', 'like', '%' . trim($this->search) . '%')
                        ->orWhere('description', 'like', '%' . trim($this->search) . '%');
                });
            })
            ->latest()
            ->get();

        return view('livewire.home-page', [
            'stats' => $stats,
            'books' => $books,
            'latestBooks' => Book::latest()->take(5)->get(),
        ])
            ->layout('components.layouts.app')
            ->title('مكتبة فايز بن سعيد الزهراني');
    }
}
