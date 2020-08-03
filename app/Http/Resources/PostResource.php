<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();

        // Modificación de estructura de retorno de JSON
        return [
            'type' => $this->getTable(),
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title
            ],

            /*
            // Ejemplo de retorno condicional
            $this->mergeWhen($user->isAdmin(), [
                'created' => $this->created_at
            ]),
            */

            // Condicional de retorno de relaciones
            // En el método show, o en el detalle de post no se ven las relaciones
            // En el listado si, por eso en el PostController se solicita esto
            $this->mergeWhen(($this->isAuthorLoaded() && $this->isCommentsLoaded()), [
                'relationships' => new PostsRelationshipsResource($this)
            ]),

            'links' => [
                'self' => route('posts.show', ['post' => $this->id])
            ]
        ];
    }
}
