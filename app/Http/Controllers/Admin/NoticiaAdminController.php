<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Http\Resources\NoticiaResource;
use App\Models\Noticia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoticiaAdminController extends Controller
{
    public function index() { return NoticiaResource::collection(Noticia::latest()->paginate(15)); }
    public function show(Noticia $noticia) { return new NoticiaResource($noticia); }

    public function store(NoticiaRequest $request)
    {
        return (new NoticiaResource(Noticia::create($this->dados($request))))->response()->setStatusCode(201);
    }

    public function update(NoticiaRequest $request, Noticia $noticia)
    {
        $noticia->update($this->dados($request, $noticia));
        return new NoticiaResource($noticia->refresh());
    }

    public function destroy(Noticia $noticia)
    {
        if ($noticia->imagem) Storage::disk('public')->delete($noticia->imagem);
        $noticia->delete();
        return response()->json(['message' => 'Notícia excluída com sucesso.']);
    }

    private function dados(NoticiaRequest $request, ?Noticia $noticia = null): array
    {
        $dados = $request->safe()->except('imagem');
        $dados['slug'] = Str::slug($dados['slug'] ?: $dados['titulo']);
        if ($request->hasFile('imagem')) {
            if ($noticia?->imagem) Storage::disk('public')->delete($noticia->imagem);
            $dados['imagem'] = $request->file('imagem')->store('noticias', 'public');
        }
        return $dados;
    }
}
