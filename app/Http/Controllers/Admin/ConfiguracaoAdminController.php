<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoAdminController extends Controller
{
    private const CHAVES = [
        'nome_site',
        'telefone',
        'email',
        'endereco',
        'horario_atendimento',
        'descricao',
    ];

    public function index()
    {
        return response()->json([
            'data' => Configuracao::whereIn('chave', self::CHAVES)->pluck('valor', 'chave'),
        ]);
    }

    public function update(Request $request)
    {
        $dados = $request->validate([
            'nome_site' => ['required', 'string', 'max:150'],
            'telefone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'horario_atendimento' => ['nullable', 'string', 'max:150'],
            'descricao' => ['nullable', 'string', 'max:1000'],
        ]);

        foreach ($dados as $chave => $valor) {
            Configuracao::updateOrCreate(['chave' => $chave], ['valor' => $valor]);
        }

        return response()->json([
            'message' => 'Configurações salvas com sucesso.',
            'data' => $dados,
        ]);
    }
}
