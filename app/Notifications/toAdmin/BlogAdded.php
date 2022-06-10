<?php

namespace App\Notifications\toAdmin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Blog;
use Illuminate\Notifications\Messages\BroadcastMessage;

class BlogAdded extends Notification
{
    use Queueable;

    public Blog $blog;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Blog $blog)
    {
        $this->blog=$blog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return[
        'user'=>request()->user()->first_name,
        'type'=>"blog",
        'title'=>"New Blog Created",
         "content"=>$this->blog,
         'seen'=>0
        ]
        ;
    }

    public function toBroadcast($notifiable)
{
    return new BroadcastMessage([
        'invoice_id' => 1,
        'amount' => 32,
    ]);
}

public function broadcastType()
{
    return 'broadcast.message';
}
}
