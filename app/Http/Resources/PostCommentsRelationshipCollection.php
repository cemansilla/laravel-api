<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCommentsRelationshipCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Capturo el parámetro adicional enviado por PostsRelationshipsResource
        $post = $this->additional['post'];

        return [
            'data' => CommentIdentifierResource::collection($this->collection),
            'links' => [
                'self' => route('posts.relationships.comments', ['post' => $post->id]),
                'related' => route('posts.comments', ['post' => $post->id])
            ]
        ];
    }
}
