<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

// Home page
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');

Route::middleware(['auth'])->group(function () {
    
    // Articles CRUD
    Route::resource('articles', ArticleController::class);

    // Overview page
    Route::get('/articles/overview', [ArticleController::class, 'overview'])
        ->name('articles.overview');

    // Toggle publish
    Route::patch('/articles/{id}/toggle', [ArticleController::class, 'togglePublish'])
        ->name('articles.toggle');
    
});



// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Profile page
Route::get('/profile', [AuthController::class, 'showProfile'])->middleware('auth')->name('profile');

// Log out route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
    