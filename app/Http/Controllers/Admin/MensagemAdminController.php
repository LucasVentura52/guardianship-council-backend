<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MensagemContato;

class MensagemAdminController extends Controller
{
    public function index()
    {
        return response()->json(MensagemContato::latest()->paginate(15));
    }

    public function marcarComoLida($id)
    {
        $mensagem = MensagemContato::findOrFail($id);
        $mensagem->update(['lida' => true]);
        return response()->json(['message' => 'Mensagem marcada como lida']);
    }

    public function destroy($id)
    {
        $mensagem = MensagemContato::findOrFail($id);
        $mensagem->delete();
        return response()->json(['message' => 'Mensagem excluída com sucesso']);
    }
}
