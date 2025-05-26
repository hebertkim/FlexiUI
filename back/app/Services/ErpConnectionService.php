<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\ErpConnection;

class ErpConnectionService
{
    public static function conectar(ErpConnection $erp)
    {
        config([
            "database.connections.{$erp->nome_conexao}" => [
                'driver' => $erp->tipo_banco,
                'host' => $erp->host,
                'port' => $erp->porta,
                'database' => $erp->database,
                'username' => $erp->username,
                'password' => decrypt($erp->password),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
            ],
        ]);

        return DB::connection($erp->nome_conexao);
    }
}
