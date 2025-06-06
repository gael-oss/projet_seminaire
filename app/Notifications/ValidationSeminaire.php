<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ValidationSeminaire extends Notification implements ShouldQueue
{
    use Queueable;

    public $seminaire;

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
            ->subject('Votre séminaire a été validé')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Le séminaire intitulé "' . $this->seminaire->theme . '" a été validé.')
            ->line('Date prévue : ' . $this->seminaire->date_presentation->format('d/m/Y'))
            ->action('Voir mes séminaires', route('seminaires.mes'))
            ->line('Merci pour votre contribution.');
    }
}
