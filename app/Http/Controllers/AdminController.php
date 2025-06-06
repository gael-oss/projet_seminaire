<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Affiche la liste des utilisateurs
    public function index()
    {
        $users = User::all();
        return view('admin.utilisateurs.index', compact('users'));
    }

    // Met à jour le rôle d'un utilisateur
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();

        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }

    // Affiche le tableau de bord administrateur
    public function dashboard()
    {
        return view('admin.dashboard_admin');
    }
}
