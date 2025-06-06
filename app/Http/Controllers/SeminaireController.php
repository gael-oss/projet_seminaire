<?php

namespace App\Http\Controllers;

use App\Models\Demande;

use App\Models\Seminaire;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\ResumeSoumisNotification;

class SeminaireController extends Controller
{
    public function create()
    {
        $this->authorize('create', Seminaire::class);
        return view('seminaires.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|string|max:255',
            'date_presentation' => 'required|date|after:today',
        ]);

        Seminaire::create([
            'theme' => $validated['theme'],
            'date_presentation' => $validated['date_presentation'],
            'presentateur_id' => Auth::id(),
            'statut' => 'demande',
        ]);

        return redirect()->route('dashboard')->with('success', 'Demande de séminaire envoyée.');
    }

    public function mesSeminaires()
    {
        $seminaires = Seminaire::where('presentateur_id', Auth::id())
            ->latest()
            ->paginate(5);

        return view('seminaires.mes_seminaires', compact('seminaires'));
    }

  public function presentateurDashboard()
  {
      if (auth()->user()->role !== 'presentateur') {
          abort(403, 'Action non autorisée');
      }
  
      $user = auth()->user();
  
      // Tous les séminaires du présentateur
      $seminaires = Seminaire::where('presentateur_id', $user->id)
          ->orderByDesc('date_presentation')
          ->take(5)
          ->get();
  
      // Prochains séminaires (5 max) pour le calendrier
      $prochains = Seminaire::where('presentateur_id', $user->id)
          ->where('date_presentation', '>=', now())
          ->orderBy('date_presentation')
          ->take(5)
          ->get();
  
      // Statistiques (total, validés, publiés)
      $stats = [
          'total'   => Seminaire::where('presentateur_id', $user->id)->count(),
          'valides' => Seminaire::where('presentateur_id', $user->id)
                                ->where('statut', 'validé')
                                ->count(),
          'publies' => Seminaire::where('presentateur_id', $user->id)
                                ->where('statut', 'publié')
                                ->count(),
      ];
  
      // Notifications non lues
      $notifications = $user->unreadNotifications;
      $user->unreadNotifications->markAsRead();
  
      return view('dashboards.dashboard_presentateur', compact(
          'seminaires',
          'prochains',
          'stats',
          'notifications'
      ));
  }

   public function editResume(Seminaire $seminaire)
   {
       $this->authorize('update', $seminaire);   // Policy
   
       // Vérification J-10
       $dateLimite = $seminaire->date_presentation->copy()->subDays(10);
       if (now()->lt($dateLimite)) {
           return back()->with('error', 'Le résumé ne peut être soumis qu’à partir de J-10.');
       }
   
       return view('seminaires.edit_resume', compact('seminaire'));
   }
   

 public function updateResume(Request $request, Seminaire $seminaire)
 {
     // 1) Autorisation : le présentateur doit être propriétaire
     $this->authorize('update', $seminaire);
 
     // 2) J-10 : on ne peut soumettre qu’à partir de J-10
     $dateLimite = \Carbon\Carbon::parse($seminaire->date_presentation)->subDays(10);
     if (now()->lt($dateLimite)) {
         return back()->with('error', 'Le résumé ne peut être soumis qu’à partir de J-10.');
     }
 
     // 3) Validation
     $request->validate([
         'resume' => 'required|string|min:20',
     ]);
 
     // 4) Mise à jour
     $seminaire->update([
         'resume' => $request->resume,
     ]);
 
     // 5) Notification à la secrétaire
     $secretaire = \App\Models\User::where('role', 'secretaire')
         ->where('email', 'secretaire@imsp.bj')
         ->first();
 
     if ($secretaire) {
         $secretaire->notify(new \App\Notifications\ResumeSoumisNotification($seminaire));
     }
 
     return redirect()
            ->route('presentateur.dashboard')
            ->with('success', 'Résumé soumis avec succès.');
 }
 

    public function uploadFichierFinal(Request $request, Seminaire $seminaire)
    {
        $this->authorize('manage-seminars');

        $aujourdhui = now()->toDateString();
        $datePresentation = $seminaire->date_presentation->toDateString();

        if ($aujourdhui !== $datePresentation) {
            return back()->with('error', 'Le fichier final ne peut être envoyé que le jour de la présentation (J+0).');
        }

        $request->validate([
            'fichier_final' => 'required|file|mimes:pdf,ppt,pptx|max:10240',
        ]);

        $path = $request->file('fichier_final')->store('fichiers_finaux', 'public');

        $seminaire->update([
            'fichier_final' => $path,
        ]);

        return back()->with('success', 'Fichier final téléversé avec succès.');
    }

    public function listePublique(Request $request)
    {
        $query = Seminaire::where('statut', 'publie')->with('presentateur');

        if ($request->filled('theme')) {
            $query->where('theme', 'like', '%' . $request->theme . '%');
        }

        if ($request->filled('presentateur')) {
            $query->whereHas('presentateur', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->presentateur . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('date_presentation', $request->date);
        }

        $seminaires = $query->orderByDesc('date_presentation')->paginate(5);

        return view('seminaires.liste_publique', compact('seminaires'));
    }

    public function exportPdf()
    {
        $seminaires = Seminaire::where('statut', 'publie')
            ->with('presentateur')
            ->orderBy('date_presentation')
            ->get();

        return Pdf::loadView('pdf.seminaires', compact('seminaires'))
            ->download('seminaires-publies-' . now()->format('Y-m-d') . '.pdf');
    }

    public function planning()
    {
        $seminaires = Seminaire::where('statut', 'publie')
            ->whereBetween('date_presentation', [now()->startOfMonth(), now()->endOfMonth()])
            ->get()
            ->groupBy(fn($s) => Carbon::parse($s->date_presentation)->format('Y-m-d'));

        return view('seminaires.planning', compact('seminaires'));
    }

    public function telechargerFichierFinal(Seminaire $seminaire)
    {
        $this->authorize('view', $seminaire);

        if (!$seminaire->fichier_final || !Storage::disk('public')->exists($seminaire->fichier_final)) {
            abort(404, 'Fichier non disponible');
        }

        return Storage::disk('public')->download($seminaire->fichier_final, "presentation-{$seminaire->id}.pdf");
    }

    public function telechargementsDisponibles()
    {
        $seminaires = Seminaire::whereNotNull('fichier_final')
            ->where('statut', 'publie')
            ->with('presentateur')
            ->latest('date_presentation')
            ->get();

        return view('etudiant.telechargement', compact('seminaires'));
    }

    public function dashboardEtudiant()
    {
        $seminaires = Seminaire::where('statut', 'publie')
            ->whereNotNull('fichier_final')
            ->with('presentateur')
            ->orderByDesc('date_presentation')
            ->get();

        return view('dashboards.dashboard_etudiant', compact('seminaires'));
    }
}
