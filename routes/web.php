<?php

use App\Livewire\HomePage;
use App\Livewire\BookShow;
use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Books\Index as AdminBooksIndex;
use App\Livewire\Admin\Messages\Index as AdminMessagesIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', HomePage::class)->name('home');
Route::redirect('/books', '/#books')->name('books.index');
Route::get('/books/{slug}', BookShow::class)->name('book.show');

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
