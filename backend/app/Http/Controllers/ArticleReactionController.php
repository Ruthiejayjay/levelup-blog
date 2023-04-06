<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReactionRequest;
use App\Http\Requests\UpdateReactionRequest;
use App\Models\Article;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;

class ArticleReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Article $article)
    {
        return $article->reactions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleReaction(StoreReactionRequest $request, Article $article)
    {
        $reaction = $article->reactions()
            ->where([
                "user_id" => auth()->id(),
                "type" => $request->type
            ])->first();

        if (!empty($reaction)) {
            $reaction->delete();
            return response()->json();
        }

        $reaction = $article->reactions()->create([
            "user_id" => auth()->id(),
            "type" => $request->type
        ]);

        return response()->json($reaction, 201);
    }
}
