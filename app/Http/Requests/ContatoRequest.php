<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'telefone' => 'nullable|string|max:30',
            'assunto' => 'required|string|max:150',
            'mensagem' => 'required|string|max:2000'
        ];
    }
}
