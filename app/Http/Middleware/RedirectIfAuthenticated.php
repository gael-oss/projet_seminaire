<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role;

                // Redirection selon le rôle de l'utilisateur
                switch ($role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'secretaire':
                        return redirect()->route('secretaire.dashboard');
                    case 'presentateur':
                        return redirect()->route('presentateur.dashboard');
                    case 'etudiant':
                        return redirect()->route('etudiant.dashboard');
                    default:
                        return redirect('/dashboard');
                }
            }
        }

        return $next($request);
    }
}
