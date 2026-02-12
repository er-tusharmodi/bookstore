<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelAuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/store', 'store')->name('store');
Route::view('/authors', 'authors')->name('authors');
Route::get('/authors/{slug}', function (string $slug) {
    return view('author-detail', ['slug' => $slug]);
})->name('author.detail');
Route::get('/books/{slug}', function (string $slug) {
    return view('book-detail', ['slug' => $slug]);
})->name('book.detail');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/admin/login', [PanelAuthController::class, 'showLogin'])->name('panel.login');
    Route::post('/admin/login', [PanelAuthController::class, 'login'])->name('panel.login.submit');
});

Route::get('/pages/{slug}', function (string $slug) {
    return view('page', ['slug' => $slug]);
})->name('page.show');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('/user/dashboard', 'user.dashboard')->name('user.dashboard');
    Route::view('/user/wishlist', 'user.wishlist')->name('user.wishlist');
    Route::view('/user/cart', 'user.cart')->name('user.cart');
    Route::view('/user/billing', 'user.billing')->name('user.billing');
    Route::view('/user/profile', 'user.profile')->name('user.profile');
    Route::view('/user/orderlist', 'user.orderlist')->name('user.orders');
});
