<?php

namespace App\Notifications;

use App\Models\demande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActiveMagasinNotification extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fromemail;
    public $mailer;
    protected $email;
    protected $nomMagasin;
    protected $nomCompletProprietaire;
    protected $adresseMagasin;
    protected $passwordMagasin;
    


    /**
     * Create a new notification instance.
     */
    public function __construct($email, $nomMagasin, $nomCompletProprietaire, $adresseMagasin,$passwordMagasin)
    {
        $this->email = $email;
        $this->nomMagasin = $nomMagasin;
        $this->nomCompletProprietaire = $nomCompletProprietaire;
        $this->adresseMagasin = $adresseMagasin;
        $this->passwordMagasin = $passwordMagasin;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Voici votre cordonées de connexion sur merch-sentry')
        ->line("Votre magasin '{$this->nomMagasin}' a été activé avec succès.")
        ->line("Votre Email est : {$this->email}")
        ->line("Votre mote de passe est : {$this->passwordMagasin}")
        ->action('se connecter', url('https://merch-sentry.com/'))
        ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
