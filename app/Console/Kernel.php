<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Import des commandes personnalisées
use App\Console\Commands\EnvoyerRappelResume;
use App\Console\Commands\PublierSeminairesJ7;
use App\Console\Commands\VerifierResumeJ10;
use App\Console\Commands\NotifierEtudiantsJ7;
use App\Console\Commands\RappelPresentateurJ1;

class Kernel extends ConsoleKernel
{
    /**
     * Enregistrement des commandes Artisan personnalisées.
     */
    protected $commands = [
        EnvoyerRappelResume::class,
        PublierSeminairesJ7::class,
        VerifierResumeJ10::class,
        NotifierEtudiantsJ7::class,
        RappelPresentateurJ1::class,
    ];

    /**
     * Définition des tâches planifiées.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Résumé à J-10
        $schedule->command('verifier:resume-j10')->dailyAt('07:00');

        // Notification à J-7 pour les étudiants
        $schedule->command('notifier:etudiants-j7')->dailyAt('08:00');

        // Notification au présentateur à J-1
        $schedule->command('notifier:presentateur-j1')->dailyAt('07:00');

        // Rappel de résumé chaque matin
        $schedule->command('rappels:resume')->dailyAt('08:00');

        // Publication automatique des séminaires à J-7
        $schedule->command('seminaires:publier-j7')->dailyAt('08:05');
    }

    /**
     * Enregistrement des commandes Artisan disponibles.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
