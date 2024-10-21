<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    //pda 객체를 생성 
    // $conn = new PDO("mysql:host=호스트명;dbname=데이터베이스명", 사용자명, 패스워드);
    $host = config('database.connections.mysql.host');
    $database = config('database.connections.mysql.database');
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');
    $conn = new PDO("mysql:host={$host};dbname={$database}", $username, $password);

    //쿼리 준비 
    $body = $request->input('body');
    $stmt = $conn->prepare("insert into articles (body, user_id) values (:body ,:userId)");

    //퀄리 값을 설정 
    $stmt->bindValue(':body', $input['body']);
    // $stmt->bindValue(':userId', $request->user()->id);
    // $stmt->bindValue(':userId', Auth::user()->id);
    $stmt->bindValue(':userId', Auth::id());



    //실행
    $stmt->execute();
    return 'hello';
});


require __DIR__ . '/auth.php';
