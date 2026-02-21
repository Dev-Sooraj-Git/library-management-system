<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;

Route::redirect('/', '/authors'); // onload of root of site, redirect to authors
Route::resource('authors', AuthorController::class); // routes for authors CRUD
Route::resource('books', BooksController::class); //routes for books CRUD

