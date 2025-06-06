<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // <-- Ajoutez cette ligne
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\Seminaire;
use App\Policies\SeminairePolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
     User::class => UserPolicy::class,
       Seminaire::class => SeminairePolicy::class,
    // ... autres policies éventuelles
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
    Gate::define('isSecretary', function ($user) {
        return $user->role === 'secretaire';
    });
        $this->registerPolicies();

        //
    }
}
