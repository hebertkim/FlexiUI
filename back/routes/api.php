<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
| Estas são as rotas da API da sua aplicação. Elas são carregadas pelo
| RouteServiceProvider e agrupadas sob o middleware "api".
|
*/

// Rota pública para criar usuário (POST)
Route::post('user', [UserController::class, 'store']);

// Rotas de autenticação
Route::post('login', [AuthController::class, 'login']); // Login
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Logout

// Rotas protegidas por autenticação (para ações show, update e destroy)
Route::middleware('auth:sanctum')->group(function () {
    // Rota para exibir dados do usuário autenticado (GET)
    Route::get('user', [UserController::class, 'show']);  // Alterado para /api/user
    // Rota para exibir dados de um usuário específico (GET)
    Route::get('user/{id}', [UserController::class, 'show']);  // Caso queira manter a busca por ID

    // Rota para atualizar os dados de um usuário (PUT ou PATCH)
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::patch('user/{id}', [UserController::class, 'update']);
    
    // Rota para excluir um usuário (DELETE)
    Route::delete('user/{id}', [UserController::class, 'destroy']);
});
