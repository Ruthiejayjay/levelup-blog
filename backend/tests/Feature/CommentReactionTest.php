<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentReactionTest extends TestCase
{
    // use RefreshDatabase;
    public function test_reaction_get()
    {
        // $article = Article::factory()->createOne();
        $comment = Comment::factory()->createOne();
        $reactions = Reaction::factory(3)
            ->set('reactable_id', $comment->id)
            ->set('reactable_type', 'comment')
            ->create();

        $response = $this->getJson("/api/comments/{$comment->id}/reactions");
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_reaction_post()
    {
        $reactingUser = User::factory(1)->create()[0];
        $comment = Comment::factory()->createOne();

        $response = $this
            ->actingAs($reactingUser)
            ->postJson(
                route('comments.reaction', ['comment' => $comment->id]),
                ['type' => 'surprised']
            );

        $response->assertStatus(201);
        $response->assertJson([
            'reactable_id' => $comment->id,
            'reactable_type' => 'comment',
            'type' => 'surprised',
            'user_id' => $reactingUser->id
        ]);
    }
}
