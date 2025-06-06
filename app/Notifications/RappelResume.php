<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelResume extends Notification implements ShouldQueue
{
    use Queueable;

    protected $seminaire;

    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rappel : Résumé à envoyer pour votre séminaire')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Vous êtes programmé pour un séminaire le ' . $this->seminaire->date_presentation->format('d/m/Y') . '.')
            ->line('Merci de soumettre le résumé au plus vite si ce n’est pas encore fait.')
            ->action('Soumettre maintenant', url('/seminaires/mes-seminaires'))
            ->line('Ceci est un rappel automatique.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
