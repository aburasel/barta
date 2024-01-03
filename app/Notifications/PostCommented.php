<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PostCommented extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $commentNotificationDto;
    public function __construct($commentNotificationDto)
    {
        $this->commentNotificationDto = $commentNotificationDto;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }
/**
 * Get the notification's database type.
 *
 * @return string
 */
    public function databaseType(object $notifiable): string
    {
        return 'post-commented';
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        //MailMessage can be replaced by Mailable
        return (new MailMessage)
            ->subject('A new comment')
            ->greeting('Hey!')
            ->line($this->commentNotificationDto->commenter->getFullName(). ' commented  to tour post.')
            ->line($this->commentNotificationDto->post->description)
            ->line(new HtmlString('<b>'.$this->commentNotificationDto->comment->comment.'</b>'))
            ->action('View Post', route('feed.single', $this->commentNotificationDto->post->id))
            ->line('Thanks for using ' . config('app.name') . '!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->commentNotificationDto->commenter->getFullName()
            . ' commented to your post ' . '\'' . $this->commentNotificationDto->comment->comment . '\'',
        ];
    }
}
