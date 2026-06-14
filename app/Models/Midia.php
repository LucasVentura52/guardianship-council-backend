<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_original',
        'arquivo',
        'mime_type',
        'tamanho',
        'alt_text',
        'user_id'
    ];
}
