<?php

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

Route::get('/articles/create', function () {
    return view('articles/create');
})->name('articles.create');

Route::post('/articles', function (Request $request) {
    //비어 있지 않고, 문자열이고, 255자를 넘으면 안된다. 
    $input = $request->validate([
        'body' => [
            'required',
            'string',
            'max:50'
        ]
    ]);

    Article::create([
        'body' => $input['body'],
        'user_id' => Auth::id()
    ]);
    return redirect()->route('articles.index');
})->name('articles.store');

Route::get('/articles', function (Request $request) {
    $perPage = $request->input('per_page', 4);;

    $articles = Article::with('user')
        ->latest()
        ->paginate($perPage);

    return view(
        'articles/index',
        [
            'articles' => $articles
        ]
    );
})->name('articles.index');

Route::get('/articles/{article}', function (Article $article) {
    return view('articles.show', ['article' =>  $article]);
})->name('articles.show');


Route::get('/articles/{article}/edit', function (Article $article) {
    return view('articles.edit', ['article' =>  $article]);
})->name('articles.edit');

Route::patch('/articles/{article}', function (Request $request, Article $article) {
    $input = $request->validate([
        'body' => [
            'required',
            'string',
            'max:50'
        ]
    ]);

    $article->body = $input['body'];
    $article->save();
    return redirect()->route('articles.index');
})->name('articles.update');

Route::delete('/articles/{article}', function (Article $article) {
    $article->delete();
    return redirect()->route('articles.index');
})->name('articles.delete');

require __DIR__ . '/auth.php';
