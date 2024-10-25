<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function create()
    {
        return view('articles/create');
    }

    public function store(Request $request)
    {
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
    }

    public function index(Request $request)
    {
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
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' =>  $article]);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', ['article' =>  $article]);
    }

    public function update(Request $request, Article $article)
    {
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
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
