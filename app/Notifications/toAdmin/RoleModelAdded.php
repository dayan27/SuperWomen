<?php

namespace App\Notifications\toAdmin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\RoleModel;
class RoleModelAdded extends Notification
{
    use Queueable;

    public  $roleModel;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $roleModel)
    {
        $this->roleModel=$roleModel;
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
        $user=request()->user();
        return[
            'user'=>$user->first_name.' ' . $user->first_name,
            "profile"=>$user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture : null,
             'type'=>"rolemodel",
            'title'=>"New Role Model Created",
             "id"=>$this->roleModel->id,
             'seen'=>0
            ];
    }
}
