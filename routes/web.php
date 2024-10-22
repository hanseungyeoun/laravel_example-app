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
});

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
    return 'hello';
});

Route::get('/articles', function (Request $request) {
    $page = $request->input('page', 1);
    $perPage = $request->input('per_page', 2);;
    $offset = ($page - 1) * $perPage;
    $totalCount = Article::count();

    $articles = Article::latest()
        ->offset($offset)
        ->limit($perPage)
        ->get();
    return view(
        'articles/index',
        [
            'articles' => $articles,
            'totalCount' => $totalCount,
            'page' => $page,
            'perPage' => $perPage
        ]
    );
});

require __DIR__ . '/auth.php';
