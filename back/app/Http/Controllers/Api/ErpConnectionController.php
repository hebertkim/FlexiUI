<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ErpConnection;

class ErpConnectionController extends Controller
{
    public function index()
    {
        return ErpConnection::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_conexao' => 'required|string',
            'tipo_banco' => 'required|string',
            'host' => 'required|string',
            'porta' => 'required|string',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $password = $request->input('password', ''); // garante string vazia, não null

        // Sempre atualiza o primeiro (único) registro existente ou cria um novo
        $conexao = \App\Models\ErpConnection::updateOrCreate(
            ['id' => 1], // força usar o ID 1
            $validated
        );

        return response()->json($conexao, 200);
    }

    public function show($id)
    {
        $erp = ErpConnection::findOrFail($id);
        return response()->json($erp);
    }

    public function update(Request $request, $id)
    {
        $erp = ErpConnection::findOrFail($id);

        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = encrypt($data['password']);
        }

        $erp->update($data);

        return response()->json(['success' => true, 'data' => $erp]);
    }

    public function destroy($id)
    {
        $erp = ErpConnection::findOrFail($id);
        $erp->delete();

        return response()->json(['success' => true]);
    }
}
