<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PublicationSeminaire extends Notification
{
    use Queueable;

    protected $seminaire;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    /**
     * Canal utilisé : email.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Contenu du message email.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Séminaire publié')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre séminaire "' . $this->seminaire->theme . '" a été publié sur la plateforme.')
            ->line('Les étudiants peuvent désormais le consulter et télécharger votre présentation.')
            ->salutation('Merci, L’équipe IMSP');
    }
}

