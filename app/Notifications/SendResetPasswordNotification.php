<?php

namespace App\Notifications;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class SendResetPasswordNotification extends Notification
{
    use Queueable;

    public $url;

    public $template;
    /**
     * Create a new notification instance.
     */
    public function __construct($url)
    {
        $this->url = $url;

        $this->template = EmailTemplate::query()
            ->where('type', 'reset-password')->first();
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
        $content = $this->template->content;
        $bladeRender = Blade::render('vendor.mail.html.button', [
            'url' => $this->url,
            'slot' => 'Redefinir senha'
        ]);

        $content = str_replace('{{ button }}', $bladeRender, $content);
        
        return (new MailMessage)
                ->subject($this->template->subject)
                ->markdown('mail.reset-password', ['url' => $this->url, 'content' => $content]);
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
