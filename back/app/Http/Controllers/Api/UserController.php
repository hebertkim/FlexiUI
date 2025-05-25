<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Lista todos os usuários
    public function index()
    {
        $users = User::all();
        Log::info('Lista de usuários retornada com sucesso.', ['total_users' => count($users)]);
        return response()->json($users, 200);
    }

    // Cria um novo usuário
    public function store(Request $request)
    {
        // Autoriza o usuário atual para criar novos usuários
        $this->authorize('create', User::class);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|string|in:admin,user',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role ?? 'user'; // default 'user'
        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }


    // Exibe os dados de um usuário específico
    public function show($id = null)
    {
        // Se não passar ID, buscar o usuário autenticado
        if (!$id) {
            $user = auth()->user();
        } else {
            // Caso contrário, buscar o usuário pelo ID
            $user = User::find($id);
        }

        // Verifica se o usuário foi encontrado
        if (!$user) {
            Log::warning('Usuário não encontrado.', ['user_id' => $id]);
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        Log::info('Usuário encontrado.', ['user_id' => $user->id]);
        return response()->json($user, 200);
    }

    // Atualiza os dados de um usuário
    public function update(Request $request, $id)
    {
        Log::info('Recebendo dados para atualização do usuário.', ['user_id' => $id, 'data' => $request->all()]);

        $user = User::find($id);

        if (!$user) {
            Log::warning('Usuário não encontrado para atualização.', ['user_id' => $id]);
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        try {
            // Validação de entrada para atualização
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'password' => 'sometimes|string|min:8|confirmed',
            ]);

            Log::info('Dados validados com sucesso para atualização.', ['validated_data' => $validated]);

            // Faz o hash da senha se ela for atualizada
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            Log::info('Usuário atualizado com sucesso.', ['user_id' => $user->id]);
            return response()->json($user, 200);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao tentar atualizar usuário.', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Erro inesperado ao tentar atualizar usuário.', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Erro no servidor.'], 500);
        }
    }

    // Exclui um usuário
    public function destroy($id)
    {
        Log::info('Recebendo solicitação para excluir usuário.', ['user_id' => $id]);

        $user = User::find($id);

        if (!$user) {
            Log::warning('Usuário não encontrado para exclusão.', ['user_id' => $id]);
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        try {
            $user->delete();
            Log::info('Usuário excluído com sucesso.', ['user_id' => $user->id]);
            return response()->json(['message' => 'Usuário excluído com sucesso.'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao tentar excluir o usuário.', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir o usuário.'], 500);
        }
    }
}
