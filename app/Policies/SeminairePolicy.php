<?php

namespace App\Policies;

use App\Models\Seminaire;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
class SeminairePolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'presentateur';
    }

    public function update(User $user, Seminaire $seminaire): bool
    {
        return $user->id === $seminaire->presentateur_id;
    }

    public function validate(User $user, Seminaire $seminaire): bool
    {
        return $user->role === 'secretaire';
    }

    public function publish(User $user, Seminaire $seminaire): bool
    {
        return $user->role === 'secretaire';
    }

    public function reject(User $user, Seminaire $seminaire): bool
    {
        return $user->role === 'secretaire';
    }

    public function downloadSecretary(User $user, Seminaire $seminaire): bool
    {
        return $user->role === 'secretaire';
    }

    public function telecharger(User $user, Seminaire $seminaire)
    {
        return $user->role === 'etudiant';
    }
    
}
