<?php

namespace App\Notifications\toAdmin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MentorRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $mentor;
    public function __construct($mentor)
    {
        $this->mentor=$mentor;
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
            'user'=>$this->mentor->first_name .' '.$this->mentor->last_name,
            'type'=>"mentor",
            'title'=>"New Mentor Registerd",
            "id"=>$this->mentor->id,
            "profile"=>$this->mentor->profile_picture ? asset('/profilepictures').'/'.$this->mentor->profile_picture : null,
            'seen'=>0
            ];
    }
}
