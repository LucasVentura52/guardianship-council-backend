<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Configuracao::pluck('valor', 'chave'),
        ]);
    }
}
