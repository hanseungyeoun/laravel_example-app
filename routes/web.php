<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
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
    // $body = $_POST['body'];

    // if (!$body) {
    //     return redirect()->back();
    // }

    // if (!is_string($body)) {
    //     return redirect()->back();
    // }

    // if (!strlen($body) > 255) {
    //     return redirect()->back();
    // }
    $request->validate([
        'body' => [
            'required',
            'string',
            'max:255'
        ]
    ]);

    return 'hello';
});


require __DIR__ . '/auth.php';
