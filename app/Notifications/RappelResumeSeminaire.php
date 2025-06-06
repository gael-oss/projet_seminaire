<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelResumeSeminaire extends Notification implements ShouldQueue
{
    use Queueable;

    public $seminaire;

    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Rappel : Soumission du résumé du séminaire')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Ce message est un rappel concernant votre séminaire intitulé :')
            ->line('**' . $this->seminaire->theme . '** prévu pour le ' . $this->seminaire->date_presentation->format('d/m/Y') . '.')
            ->line('Merci de soumettre le résumé au plus tard aujourd’hui.')
            ->action('Soumettre le résumé', url('/seminaires/mes-seminaires'))
            ->line('Merci pour votre contribution scientifique.');
    }
}
