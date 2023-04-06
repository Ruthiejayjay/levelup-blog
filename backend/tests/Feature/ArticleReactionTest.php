<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleReactionTest extends TestCase
{
    // use RefreshDatabase;
    public function test_reaction_get()
    {
        $article = Article::factory()->createOne();
        $reactions = Reaction::factory(3)
            ->set('reactable_id', $article->id)
            ->set('reactable_type', 'article')
            ->create();

        $response = $this->getJson("/api/articles/{$article->slug}/reactions");
        $response->assertStatus(200);
        // $response->assertJsonCount(3);
    }

    public function test_reaction_post()
    {
        $reactingUser = User::factory(1)->create()[0];
        $article = Article::factory()->createOne();

        $response = $this
            ->actingAs($reactingUser)
            ->postJson(
                route('articles.reaction', ['article' => $article->slug]),
                ['type' => 'surprised']
            );

        $response->assertStatus(201);
        $response->assertJson([
            'reactable_id' => $article->id,
            'reactable_type' => 'article',
            'type' => 'surprised',
            'user_id' => $reactingUser->id
        ]);
    }
}
