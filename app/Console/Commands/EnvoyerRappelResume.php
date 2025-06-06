<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminaire;
use App\Notifications\RappelResumeSeminaire;
use Carbon\Carbon; // CORRECTION : on importe Carbon depuis le bon namespace

class EnvoyerRappelResume extends Command
{
    protected $signature = 'rappels:resume';
    protected $description = 'Envoie un rappel aux présentateurs 10 jours avant leur séminaire pour soumettre leur résumé';

    public function handle()
    {
        // On récupère la date cible au format YYYY-MM-DD
        $dateCible = Carbon::now()
            ->addDays(10)
            ->toDateString();

        // On sélectionne les séminaires validés pour cette date
        $seminaires = Seminaire::where('statut', 'validé')
            ->whereDate('date_presentation', $dateCible)
            ->with('presentateur')
            ->get();

        foreach ($seminaires as $seminaire) {
            $presentateur = $seminaire->presentateur;
            if ($presentateur) {
                // On envoie la notification
                $presentateur->notify(new RappelResumeSeminaire($seminaire));
                $this->info("Rappel envoyé à {$presentateur->email}");
            }
        }

        $this->info('Tous les rappels ont été envoyés.');
    }
}
