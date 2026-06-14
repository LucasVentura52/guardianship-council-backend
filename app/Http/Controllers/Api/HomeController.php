<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampanhaResource;
use App\Http\Resources\NoticiaResource;
use App\Http\Resources\PaginaResource;
use App\Http\Resources\TelefoneUtilResource;
use App\Models\Campanha;
use App\Models\Configuracao;
use App\Models\Noticia;
use App\Models\Pagina;
use App\Models\TelefoneUtil;

class HomeController extends Controller
{
    public function index()
    {
        $campanhas = Campanha::where('status', 'publicado')
            ->where('destaque', true)
            ->orderByDesc('data_publicacao')
            ->limit(4)
            ->get();

        $noticias = Noticia::where('status', 'publicado')
            ->orderByDesc('data_publicacao')
            ->limit(3)
            ->get();

        $telefones = TelefoneUtil::where('status', 'publicado')
            ->orderBy('id')
            ->get();

        $paginaComoAcionar = Pagina::where('slug', 'como-acionar')
            ->where('status', 'publicado')
            ->first();

        return response()->json([
            'campanhas' => CampanhaResource::collection($campanhas),
            'noticias' => NoticiaResource::collection($noticias),
            'telefones' => TelefoneUtilResource::collection($telefones),
            'pagina_como_acionar' => $paginaComoAcionar ? new PaginaResource($paginaComoAcionar) : null,
            'configuracoes' => Configuracao::pluck('valor', 'chave'),
        ]);
    }
}
