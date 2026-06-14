<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sugestao;
use Illuminate\Http\Request;

class SugestaoAdminController extends Controller
{
    public function index()
    {
        $query = Sugestao::latest();

        if (request('status')) {
            $query->where('status', request('status'));
        }

        return response()->json($query->paginate(15));
    }

    public function aprovar($id)
    {
        $sugestao = Sugestao::findOrFail($id);
        $sugestao->update(['status' => 'aprovada']);
        return response()->json(['message' => 'Sugestão aprovada com sucesso']);
    }

    public function reprovar(Request $request, $id)
    {
        $request->validate(['resposta_admin' => ['nullable', 'string', 'max:2000']]);
        $sugestao = Sugestao::findOrFail($id);
        $sugestao->update([
            'status' => 'reprovada',
            'resposta_admin' => $request->input('resposta_admin'),
        ]);
        return response()->json(['message' => 'Sugestão reprovada com sucesso']);
    }
}
