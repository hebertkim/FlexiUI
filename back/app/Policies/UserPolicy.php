<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    // Outros métodos de autorização que desejar...
}
