<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\BookMessage;
use Filament\Widgets\Widget;

class LibraryStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.library-stats-widget';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'totalViews' => Book::sum('views_count'),
            'totalDownloads' => Book::sum('downloads_count'),
            'unreadMessages' => BookMessage::where('is_read', false)->count(),
            'recentMessages' => BookMessage::with('book')->latest()->take(5)->get(),
        ];
    }
}
