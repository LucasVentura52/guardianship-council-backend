<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campanha;
use App\Models\MensagemContato;
use App\Models\Noticia;
use App\Models\Sugestao;
use App\Models\Visita;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $inicio = now()->subDays(6)->startOfDay();
        $sugestoesRecentes = Sugestao::where('created_at', '>=', $inicio)->get(['created_at']);
        $mensagensRecentes = MensagemContato::where('created_at', '>=', $inicio)->get(['created_at']);
        $visitasRecentes = Visita::where('created_at', '>=', $inicio)->get(['created_at']);

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
                'acessos_7_dias' => $visitasRecentes->count(),
            ],
            'sugestoes_por_status' => collect(['pendente', 'aprovada', 'reprovada'])
                ->mapWithKeys(fn (string $status) => [
                    $status => Sugestao::where('status', $status)->count(),
                ]),
            'atividade_ultimos_7_dias' => collect(range(0, 6))->map(function (int $offset) use ($inicio, $sugestoesRecentes, $mensagensRecentes) {
                $dia = $inicio->copy()->addDays($offset);
                $sugestoes = $this->contarNoDia($sugestoesRecentes, $dia->toDateString());
                $mensagens = $this->contarNoDia($mensagensRecentes, $dia->toDateString());

                return [
                    'data' => $dia->toDateString(),
                    'rotulo' => $dia->locale('pt_BR')->translatedFormat('D'),
                    'sugestoes' => $sugestoes,
                    'mensagens' => $mensagens,
                    'total' => $sugestoes + $mensagens,
                ];
            }),
            'acessos_ultimos_7_dias' => collect(range(0, 6))->map(function (int $offset) use ($inicio, $visitasRecentes) {
                $dia = $inicio->copy()->addDays($offset);

                return [
                    'data' => $dia->toDateString(),
                    'rotulo' => $dia->locale('pt_BR')->translatedFormat('D'),
                    'total' => $this->contarNoDia($visitasRecentes, $dia->toDateString()),
                ];
            }),
            'campanhas_recentes' => Campanha::latest()->limit(5)->get(),
            'sugestoes_recentes' => Sugestao::latest()->limit(5)->get(),
            'mensagens_recentes' => MensagemContato::latest()->limit(5)->get(),
        ]);
    }

    private function contarNoDia(Collection $registros, string $data): int
    {
        return $registros->filter(
            fn ($registro) => $registro->created_at?->toDateString() === $data
        )->count();
    }
}
