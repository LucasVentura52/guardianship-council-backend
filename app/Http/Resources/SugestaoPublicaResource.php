<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SugestaoPublicaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'assunto' => $this->assunto,
            'mensagem' => $this->mensagem,
            'created_at' => $this->created_at,
        ];
    }
}
