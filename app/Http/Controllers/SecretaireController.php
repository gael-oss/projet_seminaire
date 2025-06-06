<?php

namespace App\Http\Controllers;

use App\Models\Seminaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SeminairesExport;
use App\Notifications\{
    DemandeValideeNotification,
    DemandeRejeteeNotification,
    PublicationSeminaire,
    PublicationSeminaireEtudiant
};

class SecretaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:secretaire');
    }

    public function dashboard()
    {
        $stats = $this->getStats();
        $prochains = $this->getProchains();
        $demandes = Seminaire::with('presentateur')
            ->where('statut', 'demande')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('secretaire.dashboard_secretaire', compact('stats', 'prochains', 'demandes'));
    }

    public function index()
    {
        $seminaires = Seminaire::where('statut', 'soumis')
            ->with('presentateur')
            ->latest()
            ->paginate(10);

        return view('secretaire.seminaires.index', compact('seminaires'));
    }

    public function demandes()
    {
        $demandes = Seminaire::with('presentateur')
            ->where('statut', 'demande')
            ->latest()
            ->take(5)
            ->get();

        return view('secretaire.dashboard_secretaire', [
            'stats' => $this->getStats(),
            'prochains' => $this->getProchains(),
            'demandes' => $demandes,
        ]);
    }

     /* ------------------------------------------------------------------ */
    public function show(Seminaire $seminaire)
    {
        // Option : ne montrer que les validés/publiés
        // if ($seminaire->statut === 'demande') abort(404);

        return view('secretaire.seminaires.show', compact('seminaire'));
    }

    private function getStats()
    {
        return [
            'total' => Seminaire::count(),
            'valides' => Seminaire::where('statut', 'validé')->count(),
            'publies' => Seminaire::where('statut', 'publié')->count(),
        ];
    }

    private function getProchains()
    {
        return Seminaire::with('presentateur')
            ->where('statut', 'validé')
            ->whereDate('date_presentation', '>', now())
            ->orderBy('date_presentation')
            ->limit(5)
            ->get();
    }

    public function validerDemande(Seminaire $seminaire)
    {
        $seminaire->update(['statut' => 'validé']);
        $seminaire->presentateur->notify(new DemandeValideeNotification($seminaire));

        return back()->with('success', 'La demande a été validée.');
    }

    public function rejeterDemande(Request $request, Seminaire $seminaire)
    {
        $request->validate(['motif' => 'required|string|max:255']);

        $seminaire->update([
            'statut' => 'rejeté',
            'motif_rejet' => $request->motif,
        ]);

        $seminaire->presentateur->notify(new DemandeRejeteeNotification($seminaire, $request->motif));

        return back()->with('error', 'La demande a été rejetée.');
    }

    public function publier(Seminaire $seminaire): RedirectResponse
    {
        $this->authorize('publish', $seminaire);

        $seminaire->update([
            'statut' => 'publié',
            'date_publication' => now(),
        ]);

        $seminaire->presentateur->notify(new PublicationSeminaire($seminaire));

        $etudiants = User::where('role', 'etudiant')->get();
        foreach ($etudiants as $etudiant) {
            $etudiant->notify(new PublicationSeminaireEtudiant($seminaire));
        }

        return back()->with('success', 'Séminaire publié avec succès.');
    }

    public function uploadFichierFinal(Request $request, Seminaire $seminaire)
    {
        $this->authorize('manage-seminars');

        if (now()->lt($seminaire->date_presentation)) {
            return back()->with('error', 'Vous ne pouvez envoyer le fichier final qu’après la présentation.');
        }

        $request->validate([
            'fichier_final' => 'required|file|mimes:pdf,ppt,pptx|max:10240',
        ]);

        $path = $request->file('fichier_final')->store('fichiers_finaux', 'public');

        $seminaire->update([
            'fichier_final' => $path
        ]);

        return back()->with('success', 'Fichier final téléversé avec succès.');
    }

    public function updateResume(Request $request, Seminaire $seminaire)
    {
        $dateLimite = Carbon::parse($seminaire->date_presentation)->subDays(10);

        if (now()->lt($dateLimite)) {
            return back()->with('error', 'Le résumé ne peut être soumis qu’à partir de J-10.');
        }

        $request->validate([
            'resume' => 'required|string|max:5000',
        ]);

        $seminaire->update([
            'resume' => $request->resume,
        ]);

        return back()->with('success', 'Résumé soumis avec succès.');
    }

    public function afficherResume(Seminaire $seminaire)
    {
        return view('secretaire.seminaires.resume', compact('seminaire'));
    }

    public function exportPdf()
    {
        $seminaires = Seminaire::where('statut', 'publié')
            ->with('presentateur')
            ->orderBy('date_presentation')
            ->get();

        return Pdf::loadView('pdf.seminaires', compact('seminaires'))
            ->download('seminaires-publies-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new SeminairesExport, 'seminaires.xlsx');
    }

    public function planning()
    {
        $seminaires = Seminaire::whereIn('statut', ['validé', 'publié'])
            ->whereMonth('date_presentation', now()->month)
            ->whereYear('date_presentation', now()->year)
            ->get();

        $evenements = $seminaires->map(function ($s) {
            return [
                'title' => $s->theme,
                'start' => $s->date_presentation->format('Y-m-d'),
                'url' => route('secretaire.resume', $s),
            ];
        });

        return view('secretaire.planning', ['evenements' => $evenements]);
    }

    public function listePublique()
    {
        $seminaires = Seminaire::where('statut', 'publié')
            ->orderBy('date_presentation', 'desc')
            ->with('presentateur')
            ->get();

        return view('seminaires_public', compact('seminaires'));
    }

    public function telechargerFichierFinal(Seminaire $seminaire)
    {

    
    $this->authorize('telecharger', $seminaire); // 🛡️ ligne ajoutée

        if (!$seminaire->fichier_final || !Storage::disk('public')->exists($seminaire->fichier_final)) {
            abort(404, 'Fichier non disponible.');
        }

        return Storage::disk('public')->download($seminaire->fichier_final, 'presentation-final.pdf');
            }
}
