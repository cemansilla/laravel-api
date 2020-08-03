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
                    'self' => '',
                    'related' => ''
                ],
                'data' => new AuthorIdentifierResource($this->author) // Referencia definida en el model
            ],
            // Los comentarios son de tipo collection, ya que pueden ser varios
            'comments' => new PostCommentsRelationshipCollection($this->comments)
        ];
    }
}
