<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PaginaRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', Rule::unique('paginas')->ignore($this->route('pagina'))],
            'chamada' => 'nullable|string|max:150',
            'resumo' => 'required|string|max:1000',
            'icone' => 'required|string|in:book,chart,document,email,heart,info,message,phone,shield,users',
            'conteudo' => 'required|string',
            'status' => 'required|string|in:publicado,rascunho,inativo'
        ];
    }
}
