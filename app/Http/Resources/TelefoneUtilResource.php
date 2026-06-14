<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TelefoneUtilResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'telefone' => $this->telefone,
            'descricao' => $this->descricao,
            'status' => $this->status,
        ];
    }
}
