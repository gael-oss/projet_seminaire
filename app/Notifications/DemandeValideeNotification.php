<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DemandeValideeNotification extends Notification
{
    use Queueable;

    public function __construct(public Seminaire $seminaire) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Demande de séminaire validée')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line("Votre demande de séminaire sur le thème : \"{$this->seminaire->theme}\" a été validée.")
            ->line('Vous serez bientôt notifié pour la suite (résumé à soumettre à J-10).')
            ->line('Merci pour votre collaboration.');
    }
}
