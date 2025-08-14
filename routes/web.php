<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

// Home page
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');

// CRUD routes for articles
Route::resource('articles', ArticleController::class);

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Profile page
Route::get('/profile', function () {
    return view('profile');
})->name('profile');
    //})->middleware('auth')->name('profile');
