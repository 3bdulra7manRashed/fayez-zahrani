<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class DownloadButton extends Component
{
    public Book $book;
    public bool $large = false;

    public function download()
    {
        // Increment downloads count directly as requested by the client
        $this->book->increment('downloads_count');

        return redirect()->away($this->book->pdf_url);
    }

    public function render()
    {
        return view('livewire.download-button');
    }
}
