<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentrosCusto extends Model
{
    protected $table = 'centros_custo';
    protected $fillable = ['id', 'codigo', 'nome', 'orcamento', 'responsavel', 'ativo'];
    public $timestamps = false;
}