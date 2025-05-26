<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErpConnection extends Model
{
    protected $fillable = [
        'nome_conexao',
        'tipo_banco',
        'host',
        'porta',
        'database',
        'username',
        'password',
    ];
}
