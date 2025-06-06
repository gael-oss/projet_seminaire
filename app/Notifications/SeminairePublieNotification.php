<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SeminairePublieNotification extends Notification
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
            ->subject('📢 Nouveau séminaire publié')
            ->greeting('Bonjour cher étudiant,')
            ->line("Un nouveau séminaire a été publié :")
            ->line("Thème : {$this->seminaire->theme}")
            ->line("Résumé : {$this->seminaire->resume}")
            ->line("Date : " . $this->seminaire->date_presentation->format('d/m/Y'))
            ->action('Voir sur la plateforme', url('/seminaires-publies'))
            ->line('Merci de consulter régulièrement la plateforme.');
    }
}
