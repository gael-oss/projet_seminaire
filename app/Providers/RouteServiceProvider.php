<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Le chemin vers lequel les utilisateurs doivent être redirigés après connexion.
     */
    public const HOME = '/redirect-dashboard';
    

   public static function redirectTo()
   {
       $role = auth()->user()->role;
   
       return match ($role) {
           'admin' => route('admin.dashboard'),
           'secretaire' => route('secretaire.dashboard'),
           'presentateur' => route('presentateur.dashboard'),
           'etudiant' => route('etudiant.dashboard'),
           default => '/dashboard',
       };
   }
   

    /**
     * Définit les routes de l’application.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
