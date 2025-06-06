<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminaire;
use App\Notifications\RappelPresentation;
use Carbon\Carbon;

class RappelPresentateurJ1 extends Command
{
    protected $signature = 'notifier:presentateur-j1';
    protected $description = 'Envoyer un rappel au présentateur 1 jour avant la présentation';

    public function handle()
    {
        $date = Carbon::now()->addDay()->toDateString();

        $seminaires = Seminaire::whereIn('statut', ['validé', 'publié'])
            ->whereDate('date_presentation', $date)
            ->with('presentateur')
            ->get();

        foreach ($seminaires as $s) {
            $s->presentateur->notify(new RappelPresentation($s));
            $this->info("Rappel envoyé à {$s->presentateur->email} pour le séminaire '{$s->theme}'.");
        }
    }
}
