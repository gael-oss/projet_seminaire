<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    SeminaireController,
    SecretaireController,
    AdminController
};

// Accueil
Route::get('/', fn () => view('welcome'))->name('welcome');

// Notifications non-lues
Route::get('/dashboard/notifications', function () {
    $user = Auth::user();
    $notifications = $user->unreadNotifications;
    $user->unreadNotifications->markAsRead();
    return view('partials.notifications', compact('notifications'));
})->middleware('auth')->name('dashboard.notifications');

// Liste publique des séminaires
Route::get('/seminaires-publies', [SeminaireController::class, 'listePublique'])
    ->middleware('auth')
    ->name('seminaires.public');

// Auth scaffolding (login, register, etc.)
require __DIR__ . '/auth.php';

// Toutes les routes protégées
Route::middleware(['auth', 'verified'])->group(function () {

    // Tableau de bord générique
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Profil
    Route::prefix('profile')->group(function () {
        Route::get('/',    [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/',  [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Présentateur
    Route::middleware('role:presentateur')
        ->prefix('seminaires')
        ->group(function () {

            // Redirige les GET /resume obsolètes
            Route::get('/{seminaire}/resume', function (\App\Models\Seminaire $seminaire) {
                return redirect()
                    ->route('presentateur.dashboard')
                    ->with('error', 'Utilisez « Soumettre résumé » depuis votre tableau de bord.');
            })->name('seminaires.resume.legacy');

            // Met à jour le résumé
            Route::put('/{seminaire}/resume', [SeminaireController::class, 'updateResume'])
                ->name('seminaires.updateResume');

            // CRUD léger
            Route::get('/mes-seminaires', [SeminaireController::class, 'mesSeminaires'])->name('seminaires.mes');
            Route::get('/create',         [SeminaireController::class, 'create'])->name('seminaires.create');
            Route::post('/',              [SeminaireController::class, 'store'])->name('seminaires.store');
            Route::post('/{seminaire}/upload', [SeminaireController::class, 'uploadFichier'])
                ->name('seminaires.uploadFichier');

            // Dashboard présentateur
            Route::get('/dashboard-presentateur', [SeminaireController::class, 'presentateurDashboard'])
                ->name('presentateur.dashboard');
        });

    // Secrétaire
    Route::middleware('role:secretaire')
        ->prefix('secretaire')
        ->group(function () {

            // Tableaux et listes
            Route::get('/dashboard',  [SecretaireController::class, 'dashboard'])->name('secretaire.dashboard');
            Route::get('/seminaires', [SecretaireController::class, 'index'])->name('secretaire.seminaires');
            Route::get('/seminaires/{seminaire}', [SecretaireController::class, 'show'])
                ->name('secretaire.seminaires.show');

            // Actions sur séminaire validé/publié
            Route::post('/seminaires/{seminaire}/valider',      [SecretaireController::class, 'validerDemande'])
                ->name('secretaire.seminaires.valider');
            Route::post('/seminaires/{seminaire}/rejeter',      [SecretaireController::class, 'rejeterDemande'])
                ->name('secretaire.seminaires.reject');
            Route::post('/seminaires/{seminaire}/publier',      [SecretaireController::class, 'publier'])
                ->name('secretaire.seminaires.publier');
            Route::post('/seminaires/{seminaire}/upload-final', [SecretaireController::class, 'uploadFichierFinal'])
                ->name('secretaire.seminaires.uploadFinal');

            // Demandes en attente
            Route::get('/demandes', [SecretaireController::class, 'demandes'])->name('secretaire.demandes');
            Route::post('/demandes/{seminaire}/valider', [SecretaireController::class, 'validerDemande'])
                ->name('secretaire.demandes.valider');
            Route::post('/demandes/{seminaire}/rejeter', [SecretaireController::class, 'rejeterDemande'])
                ->name('secretaire.demandes.reject');

            // Outils
            Route::get('/planning',     [SecretaireController::class, 'planning'])->name('secretaire.planning');
            Route::get('/export-pdf',   [SecretaireController::class, 'exportPdf'])->name('secretaire.exportPdf');
            Route::get('/export-excel', [SecretaireController::class, 'exportExcel'])->name('secretaire.exportExcel');
        });

    // Étudiant
    Route::middleware('role:etudiant')->group(function () {
        Route::get('/dashboard-etudiant', [SeminaireController::class, 'dashboardEtudiant'])
            ->name('etudiant.dashboard');
        Route::get('/telechargements', [SeminaireController::class, 'telechargementsDisponibles'])
            ->name('etudiant.telechargements');
        Route::get('/telecharger/{seminaire}', [SeminaireController::class, 'telechargerFichierFinal'])
            ->name('etudiant.telecharger');
    });

    // Admin
    Route::middleware('role:admin')
        ->prefix('admin')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
            Route::get('/utilisateurs', [AdminController::class, 'index'])->name('admin.users.index');
            Route::put('/utilisateurs/{user}/role', [AdminController::class, 'updateRole'])
                ->name('admin.users.updateRole');
        });
});
