<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\BorrowingController;

Route::middleware('auth:sanctum') ->name('api.')->group(function () {
    // Books API
    Route::apiResource('books', BookApiController::class);

    // Borrowing API
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow']);
    Route::post('/books/{book}/return', [BorrowingController::class, 'return']);
    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings']);
});
