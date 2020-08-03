<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsRelationshipsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'author' => [
                'links' => [
                    'self' => route('posts.relationships.author', ['post' => $this->id]),
                    'related' => route('posts.author', ['post' => $this->id])
                ],
                'data' => new AuthorIdentifierResource($this->author) // Referencia definida en el model
            ],
            // Los comentarios son de tipo collection, ya que pueden ser varios
            // Aditional permite pasar parámetros adicionales al recurso, en este caso es necesario ya que estoy trabajando con una colección y necesito hacer referencia a cada post
            'comments' => (new PostCommentsRelationshipCollection($this->comments))->additional(['post' => $this])
        ];
    }
}
