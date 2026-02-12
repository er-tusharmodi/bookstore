<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FrontendController;

// Books
Route::get('/books', [FrontendController::class, 'getBooks']);
Route::get('/books/featured', [FrontendController::class, 'getFeaturedBooks']);
Route::get('/books/search/{query}', [FrontendController::class, 'searchBooks']);
Route::get('/books/genre/{genreId}', [FrontendController::class, 'filterByGenre']);
Route::get('/books/{id}', [FrontendController::class, 'getBook']);

// Authors
Route::get('/authors', [FrontendController::class, 'getAuthors']);
Route::get('/authors/{id}', [FrontendController::class, 'getAuthor']);

// Genres
Route::get('/genres', [FrontendController::class, 'getGenres']);

// Dashboard stats
Route::get('/stats', [FrontendController::class, 'getDashboardStats']);
