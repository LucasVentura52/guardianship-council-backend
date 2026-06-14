<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'conteudo' => $this->conteudo,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ];
    }
}
