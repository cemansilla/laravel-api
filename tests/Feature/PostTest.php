<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use \App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function stores_post()
    {
        $user = create('App\User');

        $data = [
            'title' => $this->faker->sentence(6, true),
            'content' => $this->faker->text(40),
            'author_id' => $user->id
        ];

        $response = $this->json('POST', $this->base_url . "posts", $data);

        // Según la convención el retorno de creación debe ser 201
        $response->assertStatus(201);

        // Valido si existe la data en la DB
        $this->assertDatabaseHas('posts', $data);

        // Validacion de estructura de retorno
        // https://jsonapi.org/format/#crud-creating
        $post = Post::all()->first();
        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => $post->title
            ]
        ]);
    }
}
