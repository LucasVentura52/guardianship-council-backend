<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampanhaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'descricao_curta' => $this->descricao_curta,
            'conteudo' => $this->conteudo,
            'imagem' => $this->publicImageUrl($request, $this->imagem),
            'status' => $this->status,
            'destaque' => $this->destaque,
            'data_publicacao' => $this->data_publicacao,
            'created_at' => $this->created_at,
        ];
    }

    private function publicImageUrl($request, ?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }

        $baseUrl = rtrim((string) config('app.url'), '/');
        if ($baseUrl === '' || preg_match('~://(localhost|127\.0\.0\.1)(:\d+)?$~i', $baseUrl)) {
            $baseUrl = method_exists($request, 'getSchemeAndHttpHost') ? $request->getSchemeAndHttpHost() : $baseUrl;
        }

        return rtrim($baseUrl, '/').'/api/arquivos/'.ltrim($path, '/');
    }
}
