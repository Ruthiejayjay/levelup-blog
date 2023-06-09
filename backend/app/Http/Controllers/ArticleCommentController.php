<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleCommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Article $article)
    {
        // $comments = $article->comments()->orderby('created_at', 'asc');
        $comments = $article->comments()->orderBy('created_at', 'desc')->get();
        return $comments->load('reactions', 'author');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleCommentRequest $request, Article $article)
    {
        $comment = new Comment($request->validated());
        $comment->user_id = auth()->id();
        $comment->article_id = $article->id;
        $comment->save();

        
        return $comment->load('reactions', 'author');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
