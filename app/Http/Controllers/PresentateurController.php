<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminaire;
use Illuminate\Support\Facades\Auth;

class PresentateurController extends Controller
{
    public function dashboard()
    {
        $seminaires = Seminaire::where('user_id', Auth::id())->get();
        return view('presentateur.dashboard_presentateur', compact('seminaires'));
    }

    public function create()
    {
        return view('presentateur.creer_seminaire');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'date_presentation' => 'required|date',
        ]);

        Seminaire::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'date_presentation' => $request->date_presentation,
            'statut' => 'soumis',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('presentateur.dashboard')->with('success', 'Séminaire soumis.');
    }
}
