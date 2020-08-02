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
        $this->actingAs($user, 'api');

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

    /**
     * @test
     */
    public function delete_post(){
        $user = create('App\User');
        $this->actingAs($user, 'api');

        // No es necesario enviar el usuario, ya que sólo habrá 1, y en el factory especificamos que tome uno random, al haber uno solo tomará al usuario que estamos usando
        $post = create('App\Models\Post');

        // Testeo acción
        $response = $this->json('DELETE', $this->base_url . "posts/{$post->id}")
            ->assertStatus(204);

        // Testeo si efectivamente ya no existe
        $this->assertNull(Post::find($post->id));
    }

    /**
     * @test
     */
    public function update_post(){
        $data = [
            'title' => $this->faker->sentence(6, true),
            'content' => $this->faker->text(40)
        ];

        $user = create('App\User');
        $this->actingAs($user, 'api');

        // No es necesario enviar el usuario, ya que sólo habrá 1, y en el factory especificamos que tome uno random, al haber uno solo tomará al usuario que estamos usando
        $post = create('App\Models\Post');

        // Testeo acción de actualización
        $response = $this->json('PUT', $this->base_url . "posts/{$post->id}", $data);
        $response->assertStatus(200);

        // Testeo si la data actualizada corresponde al post
        $post = $post->fresh();

        // Testeo si efectivamente ya no existe
        $this->assertEquals($post->title, $data['title']);
        $this->assertEquals($post->content, $data['content']);
    }

    /**
     * @test
     */
    public function show_post(){
        $user = create('App\User');
        $post = create('App\Models\Post');

        $response = $this->json('GET', $this->base_url . "posts/{$post->id}");
        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => $post->title
            ]
        ]);
    }
}
