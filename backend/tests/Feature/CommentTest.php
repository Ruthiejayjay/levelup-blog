<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_comment()
    {
        $user = User::factory(1)->create()[0];
        $article = Article::factory(1)->create()[0];
        $response = $this
            ->actingAs($user)
            ->post("/api/articles/$article->slug/comments", [
                'content' => 'my test content'
            ]);

        $response->assertStatus(201);
        $expectedcontent = 'my test content';
        $response->assertStatus(201);
        $comment = Comment::where('content', $expectedcontent)->firstOrFail();
        $this->assertEquals($expectedcontent, $comment->content);
    }

    public function test_user_can_update_comment()
    {
        $user = User::factory(1)->create()[0];
        $article = Article::factory(1)->create()[0];
        $comment = Comment::factory(1)->create()[0];
        $response = $this
            ->actingAs($user)
            ->patch("/api/comments/$comment->id", [
                'content' => 'update content',
                'article_id' => $article->id
            ]);

        $response->assertStatus(200);
        $expectedcontent = 'update content';
        $response->assertStatus(201);
        $comment = Comment::where('content', $expectedcontent)->firstOrFail();
        $this->assertEquals($expectedcontent, $comment->content);
    }
}
