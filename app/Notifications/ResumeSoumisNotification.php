<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResumeSoumisNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $seminaire;

    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    // 🔔 Canaux utilisés : base de données + email
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau résumé soumis')
            ->line("Le présentateur {$this->seminaire->presentateur->name} a soumis un résumé.")
            ->line("Thème : {$this->seminaire->theme}")
            ->action('Voir les séminaires', url('/seminaires'))
            ->line('Merci de votre attention.');
    }

    // 🎯 Contenu stocké dans la table `notifications`
    public function toDatabase($notifiable)
    {
        return [
            'message' => "Résumé soumis par {$this->seminaire->presentateur->name} sur le thème « {$this->seminaire->theme} ».",
            'seminaire_id' => $this->seminaire->id,
            'date' => $this->seminaire->date_presentation->format('d/m/Y'),
        ];
    }
}
