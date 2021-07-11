<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $test_data = ['title' => 'Testing post'];

    public function test_store()
    {
        // $this->withoutExceptionHandling();

        $response = $this->json('POST', '/api/posts', $this->test_data);

        $response->assertJsonStructure([
                        'id',
                        'title',
                        'created_at',
                        'updated_at'
                    ])->assertJson($this->test_data)->assertStatus(201);

        $this->assertDatabaseHas('posts', $this->test_data);
    }

    public function test_validate_title()
    {

        $response = $this->json('POST', '/api/posts', [
            'title' => ''
        ]);

        //Estatus HTTP 422
        $response->assertStatus(422)
                    ->assertJsonValidationErrors('title');
    }

    public function test_show()
    {
        $post = factory(Post::class)->create();

        $response = $this->json('GET', "/api/posts/$post->id");

        $response->assertJsonStructure([
            'id',
            'title',
            'created_at',
            'updated_at'
        ])->assertJson(['title' => $post->title])->assertStatus(200);
    }

    public function test_validate_show()
    {
        $response = $this->json('GET', '/api/posts/1000');

        $response->assertStatus(404);
    }
}
