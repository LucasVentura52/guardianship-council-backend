<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SugestaoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'assunto' => $this->assunto,
            'mensagem' => $this->mensagem,
            'status' => $this->status,
            'resposta_admin' => $this->resposta_admin,
            'created_at' => $this->created_at,
        ];
    }
}
