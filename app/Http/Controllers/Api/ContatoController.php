<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoRequest;
use App\Models\MensagemContato;

class ContatoController extends Controller
{
    public function store(ContatoRequest $request)
    {
        $mensagem = MensagemContato::create($request->validated());
        return response()->json(['data' => $mensagem, 'message' => 'Mensagem recebida com sucesso'], 201);
    }
}
