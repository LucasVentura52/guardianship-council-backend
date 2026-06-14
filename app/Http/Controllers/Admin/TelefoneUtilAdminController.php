<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelefoneUtilRequest;
use App\Http\Resources\TelefoneUtilResource;
use App\Models\TelefoneUtil;

class TelefoneUtilAdminController extends Controller
{
    public function index()
    {
        return TelefoneUtilResource::collection(TelefoneUtil::latest()->paginate(15));
    }

    public function store(TelefoneUtilRequest $request)
    {
        $telefone = TelefoneUtil::create($request->validated());
        return new TelefoneUtilResource($telefone);
    }

    public function show(TelefoneUtil $telefoneUtil)
    {
        return new TelefoneUtilResource($telefoneUtil);
    }

    public function update(TelefoneUtilRequest $request, TelefoneUtil $telefoneUtil)
    {
        $telefoneUtil->update($request->validated());
        return new TelefoneUtilResource($telefoneUtil);
    }

    public function destroy(TelefoneUtil $telefoneUtil)
    {
        $telefoneUtil->delete();
        return response()->json(['message' => 'Telefone útil excluído com sucesso']);
    }
}
