<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoticiaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'resumo' => $this->resumo,
            'conteudo' => $this->conteudo,
            'imagem' => $this->imagem ? asset('storage/'.$this->imagem) : null,
            'status' => $this->status,
            'destaque' => $this->destaque,
            'data_publicacao' => $this->data_publicacao,
            'created_at' => $this->created_at,
        ];
    }
}
