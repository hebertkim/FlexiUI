<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LancamentosContabei extends Model
{
    protected $table = 'lancamentos_contabeis';
    protected $fillable = ['id', 'data', 'descricao', 'valor', 'tipo', 'centro_custo_id', 'conta_contabil_id', 'documento_id', 'conciliado'];
    public $timestamps = false;
}