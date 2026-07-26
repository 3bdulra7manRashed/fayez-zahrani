<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookController extends Controller
{
    /**
     * Stream PDF inline with forced HTTP 200 OK and PDF content headers.
     */
    public function stream(Book $book): BinaryFileResponse
    {
        if (!$book->pdf_path || !Storage::disk('public')->exists($book->pdf_path)) {
            abort(404, 'PDF file not found on disk.');
        }

        $fullPath = Storage::disk('public')->path($book->pdf_path);

        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . rawurlencode(basename($fullPath)) . '"',
            'Content-Length' => (string) filesize($fullPath),
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
