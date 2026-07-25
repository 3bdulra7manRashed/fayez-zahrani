<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use App\Models\BookMessage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('لوحة التحكم - مكتبة فايز بن سعيد الزهراني')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_views' => Book::sum('views_count'),
            'total_downloads' => Book::sum('downloads_count'),
            'total_messages' => BookMessage::count(),
            'unread_messages' => BookMessage::where('is_read', false)->count(),
            'total_pages' => Book::sum('pages_count'),
        ];

        $recentBooks = Book::latest()->take(5)->get();
        $recentMessages = BookMessage::with('book')->latest()->take(5)->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentBooks' => $recentBooks,
            'recentMessages' => $recentMessages,
        ]);
    }
}
