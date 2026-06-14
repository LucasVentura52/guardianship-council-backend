<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticiaResource;
use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::where('status', 'publicado')
            ->orderByDesc('data_publicacao')
            ->paginate(10);

        return NoticiaResource::collection($noticias);
    }

    public function show($slug)
    {
        $noticia = Noticia::where('slug', $slug)->where('status', 'publicado')->firstOrFail();
        return new NoticiaResource($noticia);
    }
}
