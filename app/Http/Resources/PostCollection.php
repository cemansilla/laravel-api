<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Post;
use App\Models\Comment;
use App\User;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => PostResource::collection($this->collection)
        ];
    }

    /**
     * Agrega data extra al retorno o sobreescribe / merge a algún nodo
     */
    public function with($request){
        // Obtengo los autores de cada post
        $authors = $this->collection->map(function($post){
            return $post->author;
        });

        // Obtengo los comentarios de cada post
        $comments = $this->collection->flatMap(function($post){
            return $post->comments;
        });

        // Como en included necesito iterar sobre un único array, hago un merge de autores y comentarios
        $included = $authors->merge($comments);

        return [
            'links' => [
                'self' => route('posts.index')
            ],
            /*
            // Comentado porque se itera sobre el merge entre autores y comentarios
            'included' => $authors->map(function($item){
                // Como el autor es un usuario, y en dicho recurso ya especifiqué su estructura, creo un nuevo recurso para el author correspondiente
                return new UserResource($item);
            }),
            */
            'included' => $included->map(function($item){
                if($item instanceof User){
                    // Como el autor es un usuario, y en dicho recurso ya especifiqué su estructura, creo un nuevo recurso para el author correspondiente
                    return new UserResource($item);
                }if($item instanceof Comment){
                    return new CommentResource($item);
                }
            })
        ];
    }
}
