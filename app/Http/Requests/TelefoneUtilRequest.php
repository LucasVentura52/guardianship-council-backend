<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelefoneUtilRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'telefone' => 'required|string|max:50',
            'descricao' => 'nullable|string|max:255',
            'status' => 'required|string|in:publicado,inativo'
        ];
    }
}
