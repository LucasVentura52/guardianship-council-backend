<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampanhaRequest;
use App\Http\Resources\CampanhaResource;
use App\Models\Campanha;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampanhaAdminController extends Controller
{
    public function index() { return CampanhaResource::collection(Campanha::latest()->paginate(15)); }
    public function show(Campanha $campanha) { return new CampanhaResource($campanha); }

    public function store(CampanhaRequest $request)
    {
        return (new CampanhaResource(Campanha::create($this->dados($request))))->response()->setStatusCode(201);
    }

    public function update(CampanhaRequest $request, Campanha $campanha)
    {
        $campanha->update($this->dados($request, $campanha));
        return new CampanhaResource($campanha->refresh());
    }

    public function destroy(Campanha $campanha)
    {
        if ($campanha->imagem) Storage::disk('public')->delete($campanha->imagem);
        $campanha->delete();
        return response()->json(['message' => 'Campanha excluída com sucesso.']);
    }

    private function dados(CampanhaRequest $request, ?Campanha $campanha = null): array
    {
        $dados = $request->safe()->except('imagem');
        $dados['slug'] = Str::slug($dados['slug'] ?: $dados['titulo']);
        if ($request->hasFile('imagem')) {
            if ($campanha?->imagem) Storage::disk('public')->delete($campanha->imagem);
            $dados['imagem'] = $request->file('imagem')->store('campanhas', 'public');
        }
        return $dados;
    }
}
