<?php

use App\Livewire\HomePage;
use App\Livewire\BookShow;

Route::get('/', HomePage::class)->name('home');
Route::redirect('/books', '/#books')->name('books.index');
Route::get('/books/{slug}', BookShow::class)->name('book.show');
