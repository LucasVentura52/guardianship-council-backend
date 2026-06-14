<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginaRequest;
use App\Http\Resources\PaginaResource;
use App\Models\Pagina;
use Illuminate\Support\Str;

class PaginaAdminController extends Controller
{
    public function index() { return PaginaResource::collection(Pagina::latest()->paginate(15)); }
    public function show(Pagina $pagina) { return new PaginaResource($pagina); }

    public function store(PaginaRequest $request)
    {
        return new PaginaResource(Pagina::create($this->dados($request)));
    }

    public function update(PaginaRequest $request, Pagina $pagina)
    {
        $pagina->update($this->dados($request));
        return new PaginaResource($pagina->refresh());
    }

    public function destroy(Pagina $pagina)
    {
        $pagina->delete();
        return response()->json(['message' => 'Página excluída com sucesso.']);
    }

    private function dados(PaginaRequest $request): array
    {
        $dados = $request->validated();
        $dados['slug'] = Str::slug($dados['slug'] ?: $dados['titulo']);
        return $dados;
    }
}
