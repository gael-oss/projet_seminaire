<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminaire;
use App\Models\User;
use App\Notifications\ResumeSoumisNotification;
use Carbon\Carbon;

class VerifierResumeJ10 extends Command
{
    protected $signature = 'verifier:resume-j10';
    protected $description = 'Notifier si le résumé n’est pas encore soumis à J-10';

    public function handle()
    {
        $date = Carbon::now()->addDays(10)->toDateString();

        $seminaires = Seminaire::where('statut', 'validé')
            ->whereDate('date_presentation', $date)
            ->whereNull('resume')
            ->with('presentateur')
            ->get();

        $secretaire = User::where('role', 'secretaire')->first();

        foreach ($seminaires as $s) {
            if ($secretaire) {
                $secretaire->notify(new ResumeSoumisNotification($s));
            }

            $this->info("Notification envoyée pour le séminaire '{$s->theme}'.");
        }
    }
}
