<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campanha;
use App\Models\MensagemContato;
use App\Models\Noticia;
use App\Models\Sugestao;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'resumo' => [
                'campanhas' => Campanha::count(),
                'campanhas_publicadas' => Campanha::where('status', 'publicado')->count(),
                'noticias' => Noticia::count(),
                'noticias_publicadas' => Noticia::where('status', 'publicado')->count(),
                'sugestoes' => Sugestao::count(),
                'sugestoes_pendentes' => Sugestao::where('status', 'pendente')->count(),
                'mensagens' => MensagemContato::count(),
                'mensagens_nao_lidas' => MensagemContato::where('lida', false)->count(),
            ],
            'sugestoes_por_status' => Sugestao::query()
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'campanhas_recentes' => Campanha::latest()->limit(5)->get(),
            'sugestoes_recentes' => Sugestao::latest()->limit(5)->get(),
            'mensagens_recentes' => MensagemContato::latest()->limit(5)->get(),
        ]);
    }
}
