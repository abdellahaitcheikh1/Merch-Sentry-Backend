<?php

namespace App\Notifications;

use App\Models\demande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterNotification extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fromemail;
    public $mailer;


    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $account = demande::all();
            foreach($account as $acc);
        $this->message="Consultez votre nouvelle demande de création de magasin de la part ".$acc->nom;
        $this->subject="Nouvelle demande de création de magasin";
        $this->fromemail="abdellahaitchiekh77@gmail.com";
        $this->fromemail="smtp";


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
                    ->mailer('smtp')
                    ->subject($this->subject)
                    ->greeting($this->message)
                    ->action('Consultez votre demande mainetent', url('https://merch-sentry.com/historiques'))
                    ->salutation('Merci');


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
