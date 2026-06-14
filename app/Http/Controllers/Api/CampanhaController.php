<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampanhaResource;
use App\Models\Campanha;
use Illuminate\Http\Request;

class CampanhaController extends Controller
{
    public function index()
    {
        $campanhas = Campanha::where('status', 'publicado')
            ->orderByDesc('data_publicacao')
            ->paginate(10);

        return CampanhaResource::collection($campanhas);
    }

    public function show($slug)
    {
        $campanha = Campanha::where('slug', $slug)->where('status', 'publicado')->firstOrFail();
        return new CampanhaResource($campanha);
    }
}
