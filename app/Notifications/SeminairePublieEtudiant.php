namespace App\Notifications;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SeminairePublieEtudiant extends Notification
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
            ->line("Un nouveau séminaire vient d’être publié.")
            ->line("📌 **Thème** : {$this->seminaire->theme}")
            ->line("📅 **Date** : " . $this->seminaire->date_presentation->format('d/m/Y'))
            ->line("📝 **Résumé** :")
            ->line($this->seminaire->resume ?? '(Aucun résumé fourni)')
            ->action('Voir sur la plateforme', url('/seminaires-publies'))
            ->line('Merci de votre attention !');
    }
}
