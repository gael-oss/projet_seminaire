<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function isPresenter(User $user)
    {
        return $user->role === 'presentateur';
    }
    

     
    public function __construct()
    {
        //
    }
}
