<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampanhaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'descricao_curta' => $this->descricao_curta,
            'conteudo' => $this->conteudo,
            'imagem' => $this->imagem ? asset('storage/'.$this->imagem) : null,
            'status' => $this->status,
            'destaque' => $this->destaque,
            'data_publicacao' => $this->data_publicacao,
            'created_at' => $this->created_at,
        ];
    }
}
