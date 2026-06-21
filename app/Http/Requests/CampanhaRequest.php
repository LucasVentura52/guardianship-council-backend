<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CampanhaRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('titulo', '')),
        ]);
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('campanhas')->ignore($this->route('campanha'))],
            'descricao_curta' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'imagem' => 'nullable|image|max:5120',
            'status' => 'required|string|in:publicado,rascunho,inativo',
            'destaque' => 'boolean',
            'data_publicacao' => 'nullable|date'
        ];
    }
}
