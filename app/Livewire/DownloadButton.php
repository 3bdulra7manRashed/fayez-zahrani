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

        // Redirect to the actual PDF file path (local or Google Drive URL)
        // If it's a local file path, use asset('storage/' . $path), otherwise redirect directly
        $pdfUrl = filter_var($this->book->pdf_path, FILTER_VALIDATE_URL)
            ? $this->book->pdf_path
            : asset('storage/' . $this->book->pdf_path);

        return redirect()->away($pdfUrl);
    }

    public function render()
    {
        return view('livewire.download-button');
    }
}
