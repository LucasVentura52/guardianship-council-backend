<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefoneUtil extends Model
{
    use HasFactory;

    protected $table = 'telefones_uteis';

    protected $fillable = [
        'titulo',
        'telefone',
        'descricao',
        'status'
    ];
}
