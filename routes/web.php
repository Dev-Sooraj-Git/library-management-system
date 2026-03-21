<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\BorrowingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// YOUR AUTHORS & BOOKS ROUTES - PROTECTED WITH AUTH
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // YOUR RESOURCE ROUTES
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BooksController::class);

    // routes/web.php (inside auth middleware group)
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow'])->name('books.borrow');
    Route::post('/books/{book}/return', [BorrowingController::class, 'return'])->name('books.return');
    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings'])->name('borrowings.index');
});

require __DIR__ . '/auth.php';
