<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::controller(ArticleController::class)->group(function () {
//     Route::get('/articles/create', 'create')->name('articles.create');
//     Route::post('/articles', 'store')->name('articles.store');
//     Route::get('/articles', 'index')->name('articles.index');
//     Route::get('/articles/{article}', 'show')->name('articles.show');
//     Route::get('/articles/{article}/edit', 'edit')->name('articles.edit');
//     Route::patch('/articles/{article}', 'update')->name('articles.update');
//     Route::delete('/articles/{article}', 'destroy')->name('articles.destroy');
// });

Route::resource('articles', ArticleController::class);

require __DIR__ . '/auth.php';
