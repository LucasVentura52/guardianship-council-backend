<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('paginas')->ignore($this->route('pagina'))],
            'conteudo' => 'required|string',
            'status' => 'required|string|in:publicado,rascunho,inativo'
        ];
    }
}
