<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Seminaire extends Model
{
    use HasFactory;

    // Constantes pour les statuts
    const STATUT_BROUILLON = 'brouillon';
    const STATUT_SOUMIS = 'soumis';
    const STATUT_VALIDE = 'validé';
    const STATUT_REJETE = 'rejeté';
    const STATUT_PUBLIE = 'publié';

    protected $fillable = [
        'theme', // Correction du nom (titre → theme)
        'resume',
        'date_presentation',
        'statut',
        'presentateur_id', // Renommage user_id → presentateur_id
        'fichier_path',
        'date_validation',
        'date_publication',
        'motif_rejet'
    ];

    protected $dates = [
        'date_presentation',
        'date_validation',
        'date_publication',
        'created_at',
        'updated_at'
    ];

    // Relation avec le présentateur
    public function presentateur()
    {
        return $this->belongsTo(User::class, 'presentateur_id');
    }

    // Scopes pour faciliter les requêtes
    public function scopeValidated(Builder $query): Builder
    {
        return $query->where('statut', self::STATUT_VALIDE);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('statut', self::STATUT_PUBLIE);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('statut', [self::STATUT_SOUMIS, self::STATUT_BROUILLON]);
    }

    // Méthodes utilitaires
    public function estValide(): bool
    {
        return $this->statut === self::STATUT_VALIDE;
    }

    public function estPublie(): bool
    {
        return $this->statut === self::STATUT_PUBLIE;
    }
}
