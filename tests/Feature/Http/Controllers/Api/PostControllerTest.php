<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        // $this->withoutExceptionHandling();

        $test_data = ['title' => 'Testing post'];

        $response = $this->json('POST', '/api/posts', $test_data);

        $response->assertJsonStructure([
                        'id',
                        'title',
                        'created_at',
                        'updated_at'
                    ])->assertJson($test_data)->assertStatus(201);

        $this->assertDatabaseHas('posts', $test_data);

    }
}
