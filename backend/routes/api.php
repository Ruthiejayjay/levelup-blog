<?php

use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleReactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReactionController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserAvatarRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$unauthenticatedRoutes = ['index', 'show'];
// user must be authenticated to access this
Route::middleware('auth:sanctum')->group(function () use ($unauthenticatedRoutes) {
    Route::get('/me', function (Request $request) {
        return auth()->user();
    });
    Route::apiResource('articles', ArticleController::class)->except($unauthenticatedRoutes);
    Route::apiResource('comments', CommentController::class)->except($unauthenticatedRoutes);
    Route::apiResource('articles.comments', ArticleCommentController::class)->except($unauthenticatedRoutes);
});

//users can open without authentication
Route::apiResource('articles', ArticleController::class)->only($unauthenticatedRoutes);
Route::apiResource('comments', CommentController::class)->only($unauthenticatedRoutes);
Route::apiResource('articles.comments', ArticleCommentController::class)->only($unauthenticatedRoutes);

Route::apiResource('users', UserController::class)->only([
    'store', // "register" route must be available without authentication
]);
// all other user details should be available only to authenticated users
Route::apiResource('users', UserController::class)->except(['store'])->middleware('auth:sanctum');
Route::post('/users/{user}', function (Request $request, User $user) {
    $uploadAvatar = $request->validate([
        'avatar' => ['required', 'image']
    ]);
    if ($uploadAvatar) {
        $path = $request->file('avatar')->store('images', ['disk' => 'public']);
        if (!$path) {
            return response()->json(['msg' => 'avatar could not be saved'], 500);
        }
        $validated['avatar_path'] = $path;
        $user->avatar_path = $path;
        $user->save();
        return $user;
    }
})->middleware('auth:sanctum');

Route::post('/articles/{article}', function (Request $request, Article $article) {
    $updateImage = $request->validate([
        'image' => ['required', 'image']
    ]);
    if ($updateImage) {
        $path = $request->file('image')->store('images', ['disk' => 'public']);
        if (!$path) {
            return response()->json(['msg' => 'image could not be saved'], 500);
        }
        $validated['avatar_path'] = $path;
        $article->avatar_path = $path;
        $article->save();
        return $article;
    }
});

Route::apiResource('users.articles', ArticleController::class)->middleware('auth:sanctum');
Route::apiResource('users.comments', CommentController::class)->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class)->only($unauthenticatedRoutes);
Route::apiResource('categories', CategoryController::class)->middleware('auth:sanctum')->except($unauthenticatedRoutes);

Route::get('/categories/{category}/articles', function (Category $category) {
    return $category->articles()->paginate(5);
});

Route::post('/categories/{category}/articles', function (Category $category, Request $request) {
    $article = new Article($request->validate([
        'title' => 'required',
        'content' => 'required'
    ]));
    $article->user_id = auth()->id();
    if (!$article->save()) {
        return response()->json(['msg' => 'article could not be created'], 500);
    }

    $article->categories()->attach($category);
    $article->load('categories');

    dd($article);
})->middleware('auth:sanctum');

Route::delete('/articles/{article}/category/{category_id}', function (Article $article, $category_id) {
    if ($article->user_id !== auth()->id()) {
        return response()->json(['message' => 'This operation is unauthorized'], 403);
    }
    $article->categories()->detach($category_id);
    return $article->load('categories');
})->middleware('auth:sanctum');

Route::post('/authenticate', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', Password::min(8)]
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['code' => 403, 'message' => 'invalid credentials'], 403);
    }

    $user = User::where('email', $credentials['email'])->firstOrFail();

    return $user->createToken('auth_token')->plainTextToken;
});

Route::post('/articles/{article}/reactions', [ArticleReactionController::class, 'toggleReaction'])->middleware('auth:sanctum')->name('articles.reaction');
Route::get('/articles/{article}/reactions', [ArticleReactionController::class, 'index']);


Route::post('/comments/{comment}/reactions', [CommentReactionController::class, 'store'])->middleware('auth:sanctum')->name('comments.reaction');
Route::get('/comments/{comment}/reactions', [CommentReactionController::class, 'index']);
