<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tag; 

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTag()
    {
        $response = $this->postJson('/api/tags', ['name' => 'Test Tag']);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Tag',
            ]);
    }

    public function testEditTag()
    {
        $tag = Tag::factory()->create();

        $response = $this->putJson("/api/tags/{$tag->id}", ['name' => 'Updated Tag']);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Updated Tag',
            ]); 
    }
}
