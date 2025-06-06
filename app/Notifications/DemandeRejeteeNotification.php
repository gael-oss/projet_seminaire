<?php

namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DemandeRejeteeNotification extends Notification
{
    use Queueable;

    public Seminaire $seminaire;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Demande de séminaire rejetée')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line("Votre demande de séminaire ayant pour thème :")
            ->line('"' . $this->seminaire->theme . '"')
            ->line('a malheureusement été rejetée par le secrétariat scientifique.')
            ->line('Vous pouvez soumettre une nouvelle demande si vous le souhaitez.')
            ->line('Merci pour votre compréhension.');
    }

    /**
     * Get the array representation of the notification (facultatif).
     */
    public function toArray($notifiable): array
    {
        return [
            'theme' => $this->seminaire->theme,
            'statut' => 'rejeté'
        ];
    }
}
