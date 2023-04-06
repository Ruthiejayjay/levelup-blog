<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\User;
use App\Utils\StringUtils;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user = null)
    {

        return Article::query()
            ->with('author', 'categories')
            ->limit(request('limit'))
            ->Category(request('category'))
            ->orderBy('created_at', 'desc')
            ->fromUser(request('user_id') ?? $user?->id)
            ->paginate(request('per_page'))->appends(request()->all()); // uncomment if you need pagination
        //->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $validatedArticle = $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required'],
            
            'slug' => ['prohibited'],
            'user_id' => ['prohibited'],
        ]);
        $validatedArticle['user_id'] = auth()->id();
        $validatedArticle['slug'] = StringUtils::slugify($validatedArticle['title']);

        if ($request->image) {
            $path = $request->file('image')->store('images', ['disk' => 'public']);
            if (!$path) {
                return response()->json(['msg' => 'image could not be saved'], 500);
            }
            $validatedArticle['avatar_path'] = $path;
        }


        $article = new Article($validatedArticle);
        $article->save();
        $article->categories()->attach($request->categories_id);
        return $article->load('categories');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->load('comments', 'reactions', 'author', 'categories');
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $validated = $request->validated();
        $validated['slug'] = StringUtils::slugify($validated['title']);
        if ($request->image) {
            $path = $request->file('image')->store('images', ['disk' => 'public']);
            if (!$path) {
                return response()->json(['msg' => 'image could not be saved'], 500);
            }
            $validated['avatar_path'] = $path;
        }
        $article->update($validated);
        $article->categories()->attach($request->categories_id);
        return $article->load('categories');
        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete');
        $article->delete();
    }
}
