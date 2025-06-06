<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminaire;

class EtudiantController extends Controller
{
    /**
     * Affiche le tableau de bord de l'étudiant.
     */
    public function dashboard()
    {
        // Récupérer les séminaires publiés que l’étudiant peut consulter
        $seminaires = Seminaire::where('statut', 'publie')
                                ->orderBy('date_presentation', 'desc')
                                ->paginate(5);

        // Afficher la vue avec les séminaires
        return view('etudiant.dashboard_etudiant', compact('seminaires'));
    }
}
