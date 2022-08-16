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

    public $blog;
 
    public function __construct($blog)
    {
        $this->blog=$blog;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        $user=request()->user();
        return[
        'user'=>$user->first_name.' ' . $user->first_name,
        "profile"=>$user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture : null,

        'type'=>"blog",
        'title'=>"New Blog Created",
         "id"=>$this->blog->id,
         'seen'=>0
        ]
        ;
    }




}
