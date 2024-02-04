<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateArticle()
    {
        $response = $this->postJson('/api/articles', ['title' => 'Test Article']);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Article',
            ]);
    }

    public function testEditArticle()
    {
        $article = Article::factory()->create();

        $response = $this->putJson("/api/articles/{$article->id}", ['title' => 'Updated Article']);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Article',
            ]);
    }

    public function testDeleteArticle()
    {
        $article = Article::factory()->create();

        $response = $this->delete("/api/articles/{$article->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Article deleted successfully']);
    }

    public function testGetArticles()
    {
        $response = $this->get('/api/articles');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'articles' => [
                    '*' => [
                        'id',
                        'title',
                        'tags' => [
                            '*' => [
                                'id',
                                'name',
                                'pivot' => [
                                    'created_at',
                                ],
                            ],
                        ],
                    ],
                ],
                'tags' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }

    public function testGetArticleById()
    {
        $article = Article::factory()->create();

        $response = $this->get("/api/articles/{$article->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'article' => [
                    'id',
                    'title',
                    'tags' => [
                        '*' => [
                            'id',
                            'name',
                            'pivot' => [
                                'created_at',
                            ],
                        ],
                    ],
                ],
                'tags' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }
}
