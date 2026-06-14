<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SugestaoRequest;
use App\Http\Resources\SugestaoResource;
use App\Models\Sugestao;

class SugestaoController extends Controller
{
    public function aprovadas()
    {
        $sugestoes = Sugestao::where('status', 'aprovada')->latest()->get();
        return SugestaoResource::collection($sugestoes);
    }

    public function store(SugestaoRequest $request)
    {
        $sugestao = Sugestao::create(array_merge($request->validated(), ['status' => 'pendente']));
        return new SugestaoResource($sugestao);
    }
}
