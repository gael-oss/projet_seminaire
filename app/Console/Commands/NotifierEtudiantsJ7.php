<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminaire;
use App\Models\User;
use App\Notifications\PublicationSeminaire;
use Carbon\Carbon;

class NotifierEtudiantsJ7 extends Command
{
    protected $signature = 'notifier:etudiants-j7';
    protected $description = 'Notifier les étudiants des séminaires publiés à venir à J-7';

    public function handle()
    {
        $date = Carbon::now()->addDays(7)->toDateString();

        $seminaires = Seminaire::where('statut', 'publié')
            ->whereDate('date_presentation', $date)
            ->with('presentateur')
            ->get();

        $etudiants = User::where('role', 'etudiant')->get();

        foreach ($seminaires as $seminaire) {
            foreach ($etudiants as $etudiant) {
                $etudiant->notify(new PublicationSeminaire($seminaire));
            }
            $this->info("Notification envoyée aux étudiants pour '{$seminaire->theme}'.");
        }
    }
}
