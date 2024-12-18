<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\DeleteArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
        ];
    }

    public function create()
    {
        return view('articles/create');
    }


    public function store(CreateArticleRequest $request)
    {
        $input = $request->validate();
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

    public function edit(EditArticleRequest $request, Article $article)
    {
        // Gate::authorize('update', $article);
        return view('articles.edit', ['article' =>  $article]);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        // if (Auth::user()->can('update', $article)) {
        //     abort(403);
        // }
        // Gate::authorize('update', $article);
        $input = $request->validate();
        $article->body = $input['body'];
        $article->save();
        return redirect()->route('articles.index');
    }

    public function destroy(DeleteArticleRequest $request, Article $article)
    {
        // Gate::authorize('delete', $article);
        $article->delete();
        return redirect()->route('articles.index');
    }
}
