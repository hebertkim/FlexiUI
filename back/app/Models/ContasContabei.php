<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContasContabei extends Model
{
    protected $table = 'contas_contabeis';
    protected $fillable = ['id', 'codigo', 'descricao', 'tipo', 'nivel'];
    public $timestamps = false;
}