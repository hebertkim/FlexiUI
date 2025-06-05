<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ErpConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ErpConnectController extends Controller
{
    public function connect(Request $request)
    {
        $request->validate([
            'connection_id' => 'required|integer|exists:erp_connections,id',
        ]);

        $conn = ErpConnection::find($request->connection_id);

        // Montar configuração dinâmica do DB
        $connectionName = 'erp_dynamic';

        $config = [
            'driver'    => $conn->tipo_banco,
            'host'      => $conn->host,
            'port'      => $conn->porta,
            'database'  => $conn->database,
            'username'  => $conn->username,
            'password'  => $conn->password,
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'engine'    => null,
        ];

        // Adicionar conexão dinâmica ao config do Laravel
        config(["database.connections.$connectionName" => $config]);

        try {
            // Testar conexão
            DB::connection($connectionName)->getPdo();

            return response()->json([
                'success' => true,
                'message' => 'Conexão estabelecida com sucesso!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao conectar: ' . $e->getMessage(),
            ], 500);
        }
    }
    
}
