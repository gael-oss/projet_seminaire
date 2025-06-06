namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RappelPresentation extends Notification implements ShouldQueue
{
    use Queueable;

    public $seminaire;

    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('⏰ Rappel : Séminaire dans 7 jours')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre séminaire sur le thème "' . $this->seminaire->theme . '" aura lieu le ' . $this->seminaire->date_presentation->format('d/m/Y') . '.')
            ->line('Veuillez vous assurer que le résumé est bien soumis avant la date limite.')
            ->action('Voir mes séminaires', url('/seminaires/dashboard-presentateur'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Votre séminaire "' . $this->seminaire->theme . '" est prévu dans 7 jours.',
        ];
    }
}
