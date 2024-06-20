<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification
{
    use Queueable;
    private $comment;
    private $user;
    private $legalCase;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment, User $user, LegalCase $legalCase)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->legalCase = $legalCase;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'nama_depan' => $this->user->nama_depan,
            'nama_belakang' => $this->user->nama_belakang,
            'kasus' => $this->legalCase->title, // Assuming 'title' is a property of LegalCase
            'title' => 'Pembuatan Komentar Baru',
            'messages' => $this->user->nama_depan . ' ' . $this->user->nama_belakang . ' menambahkan komentar pada kasus "' . $this->legalCase->title . '"',
            'url' => route('kasus.show', ['legalCase' => $this->legalCase->id]),
        ];
    }
}
