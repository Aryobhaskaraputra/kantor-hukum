<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\LegalCase;

class CaseLogNotification extends Notification
{
    use Queueable;

    private $user;
    private $legalCase;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, LegalCase $legalCase)
    {
        $this->user = $user;
        $this->legalCase = $legalCase;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'nama_depan' => $this->user->nama_depan,
            'nama_belakang' => $this->user->nama_belakang,
            'role_id' => optional($this->user->role)->role_name,
            'kasus' => $this->legalCase->title,
            'title' => 'Pembuatan Kasus Baru',
            'messages' => $this->user->nama_depan . ' ' . $this->user->nama_belakang . ' (' . optional($this->user->role)->role_name . ') telah membuat kasus baru yang berjudul "' . $this->legalCase->title . '"',
            'url' => route('kasus.show', ['legalCase' => $this->legalCase->id]),
        ];
    }
}
