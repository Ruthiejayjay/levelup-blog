<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    //use DatabaseTransactions;

    // public function test_guest_can_see_articles()
    // {
    //     $response = $this->json('GET', '/api/articles');

    //     $response->assertStatus(200);
    //     $response->assertJson(['total' => 24]);

    //     // $response->dd();

    //     // $response->assertJson(['total' => 4]);
    // }

    public function test_user_can_create_article()
    {
        $user = User::factory(1)->create()[0];
        $response = $this
            ->actingAs($user)
            ->post('/api/articles', [
                'title' => 'this test title',
                'content' => 'my test content',
            ]);

        $response->assertStatus(201);
        $expectedSlug = 'this-test-title';
        $article = Article::where('slug', 'this-test-title')->firstOrFail();
        $this->assertEquals($expectedSlug, $article->slug);
    }

    public function test_user_can_update_article()
    {
        $user = User::factory(1)->create()[0];
        $article = Article::factory(1)->create()[0];
        $response = $this
            ->actingAs($user)
            ->patch("/api/articles/$article->slug", [
                'title' => 'update title',
                'content' => 'update content'
            ]);

        $response->assertStatus(200);
    }

    public function test_user_can_load_all_articles()
    {
        $response = $this->get('/api/articles');

        $response->assertStatus(200);
    }

    public function test_user_can_load_one_article()
    {
        $user = User::factory(1)->create()[0];
        $article = Article::factory(1)->create()[0];
        $response = $this
            ->actingAs($user)
            ->get("/api/articles/$article->slug");

        $response->assertStatus(200);
        $response->assertContains($article->content);
    }

    public function test_unauthenticated_user_cannot_create_article()
    {
        $response = $this
            ->post('/api/articles', [
                'title' => 'this test title',
                'content' => 'my test content',
            ], ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }
}
