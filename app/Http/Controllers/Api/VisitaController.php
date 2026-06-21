<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitaRequest;
use App\Models\Visita;
use Illuminate\Support\Str;

class VisitaController extends Controller
{
    public function store(VisitaRequest $request)
    {
        $caminho = parse_url($request->validated('caminho'), PHP_URL_PATH) ?: '/';
        $caminho = '/'.ltrim($caminho, '/');

        if (! Str::startsWith($caminho, '/admin')) {
            Visita::create(['caminho' => Str::limit($caminho, 255, '')]);
        }

        return response()->noContent();
    }
}
