<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ErpConnectionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rotas de autenticação públicas
Route::post('login', [AuthController::class, 'login']);

Route::apiResource('erp-connections', ErpConnectionController::class);

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
