<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campanha extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'slug',
        'descricao_curta',
        'conteudo',
        'imagem',
        'status',
        'destaque',
        'data_publicacao'
    ];

    protected $casts = ['destaque' => 'boolean', 'data_publicacao' => 'date'];
}
