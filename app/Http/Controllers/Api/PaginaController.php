<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginaResource;
use App\Models\Pagina;

class PaginaController extends Controller
{
    public function show($slug)
    {
        $pagina = Pagina::where('slug', $slug)->where('status', 'publicado')->firstOrFail();
        return new PaginaResource($pagina);
    }
}
