<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Midia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MidiaAdminController extends Controller
{
    public function index() { return response()->json(Midia::latest()->paginate(24)); }

    public function store(Request $request)
    {
        $request->validate(['arquivo' => ['required', 'image', 'max:5120'], 'alt_text' => ['nullable', 'string', 'max:255']]);
        $arquivo = $request->file('arquivo');
        $midia = Midia::create([
            'nome_original' => $arquivo->getClientOriginalName(),
            'arquivo' => $arquivo->store('midias', 'public'),
            'mime_type' => $arquivo->getMimeType(),
            'tamanho' => $arquivo->getSize(),
            'alt_text' => $request->alt_text,
            'user_id' => $request->user()->id,
        ]);
        return response()->json(['data' => $midia], 201);
    }

    public function destroy(Midia $midia)
    {
        Storage::disk('public')->delete($midia->arquivo);
        $midia->delete();
        return response()->json(['message' => 'Mídia excluída com sucesso.']);
    }
}
