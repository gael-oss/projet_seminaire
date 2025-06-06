<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminaire;
use App\Models\User;
use App\Notifications\SeminairePublieNotification;
use Carbon\Carbon;

class PublierSeminairesJ7 extends Command
{
    protected $signature = 'seminaires:publier-j7';
    protected $description = 'Publie automatiquement les séminaires 7 jours avant leur date de présentation';

    public function handle()
    {
        $dateCible = Carbon::now()->addDays(7)->startOfDay();

        $seminaires = Seminaire::where('statut', 'validé')
            ->whereDate('date_presentation', $dateCible)
            ->get();

        foreach ($seminaires as $seminaire) {
            $seminaire->update([
                'statut' => 'publié',
                'date_publication' => now()
            ]);

            $etudiants = User::where('role', 'etudiant')->get();
            foreach ($etudiants as $etudiant) {
                $etudiant->notify(new SeminairePublieNotification($seminaire));
            }

            $this->info("Séminaire '{$seminaire->theme}' publié et notification envoyée aux étudiants.");
        }

        $this->info('Tous les séminaires concernés ont été publiés.');
    }
}
