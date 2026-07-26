<?php

use App\Livewire\HomePage;
use App\Livewire\BookShow;
use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Books\Index as AdminBooksIndex;
use App\Livewire\Admin\Messages\Index as AdminMessagesIndex;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Public Routes
Route::get('/', HomePage::class)->name('home');
Route::redirect('/books', '/#books')->name('books.index');
Route::get('/books/{slug}', BookShow::class)->name('book.show');

Route::get('/books/{book}/download', function (Book $book) {
    if (!$book->pdf_path || !Storage::disk('public')->exists($book->pdf_path)) {
        abort(404);
    }
    $filename = $book->title ? $book->title . '.pdf' : basename($book->pdf_path);
    return Storage::disk('public')->download($book->pdf_path, $filename);
})->name('books.download');

// Stream PDF inline with CORS headers for PDF.js frontend viewer
Route::get('/books/{book}/stream', function (Book $book) {
    if (!$book->pdf_path || !Storage::disk('public')->exists($book->pdf_path)) {
        abort(404);
    }
    $path = Storage::disk('public')->path($book->pdf_path);
    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . rawurlencode($book->title ?: 'book') . '.pdf"',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Cache-Control' => 'no-cache, private',
    ]);
})->name('books.stream');

Route::redirect('/login', '/admin/login')->name('login');

// Admin Guest Routes
Route::get('/admin/login', AdminLogin::class)
    ->middleware('guest')
    ->name('admin.login');

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', AdminDashboard::class)->name('dashboard');
    Route::get('/books', AdminBooksIndex::class)->name('books.index');
    Route::get('/messages', AdminMessagesIndex::class)->name('messages.index');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    })->name('logout');
});
