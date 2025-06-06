<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PublicationSeminaireEtudiant extends Notification
{
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
            ->subject('📢 Nouveau séminaire publié !')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Un nouveau séminaire a été publié sur la plateforme.')
            ->line('🗓 Date : ' . $this->seminaire->date_presentation->format('d/m/Y'))
            ->line('🎓 Thème : ' . $this->seminaire->theme)
            ->line('📝 Résumé :')
            ->line($this->seminaire->resume ?? 'Aucun résumé fourni.')
            ->action('Voir les séminaires', route('seminaires.public'))
            ->line('Merci de votre attention.');
    }
}
