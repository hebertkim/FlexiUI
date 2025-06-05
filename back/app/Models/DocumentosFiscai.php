<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosFiscai extends Model
{
    protected $table = 'documentos_fiscais';
    protected $fillable = ['id', 'numero', 'serie', 'data_emissao', 'valor_total', 'cfop', 'ncm', 'cst', 'chave_acesso'];
    public $timestamps = false;
}