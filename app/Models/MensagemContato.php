<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensagemContato extends Model
{
    use HasFactory;

    protected $table = 'mensagens_contato';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'assunto',
        'mensagem',
        'lida'
    ];

    protected $casts = ['lida' => 'boolean'];
}
