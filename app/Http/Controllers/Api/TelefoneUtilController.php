<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TelefoneUtilResource;
use App\Models\TelefoneUtil;

class TelefoneUtilController extends Controller
{
    public function index()
    {
        $telefones = TelefoneUtil::where('status', 'publicado')->get();
        return TelefoneUtilResource::collection($telefones);
    }
}
