<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ErpConnectionController;
use App\Http\Controllers\Api\ErpConnectController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rotas de autenticação públicas
Route::post('login', [AuthController::class, 'login']);

Route::apiResource('erp-connections', ErpConnectionController::class);
Route::post('/erp-connect', [ErpConnectController::class, 'connect']);
Route::post('/erp-connect', [\App\Http\Controllers\Api\ErpConnectionController::class, 'conectar']);
Route::post('/gerar-migrations', [ErpConnectionController::class, 'gerarMigrations']);
Route::match(['get', 'post'], 'gerar-migrations', [ErpConnectionController::class, 'gerarMigrations']);




// Rotas protegidas por autenticação
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Usuário autenticado vê seus dados
    Route::get('user', [UserController::class, 'show']);

    // Admin pode criar usuários
    Route::middleware(['auth:sanctum', 'admin'])->post('user', [UserController::class, 'store']);

    // Mostrar, atualizar e deletar usuários - pode ajustar autorização aqui também
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::patch('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'destroy']);


    
});

Route::post('/executar-migrate', function (Request $request) {
    try {
        Artisan::call('migrate', ['--force' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Migrations executadas com sucesso.',
            'output' => Artisan::output(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao rodar migrations: ' . $e->getMessage(),
        ], 500);
    }
}); // coloque middleware ou permissão adequada