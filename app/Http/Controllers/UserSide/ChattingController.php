<?php

namespace App\Http\Controllers\UserSide;

use App\Events\AdminNotification;
use App\Events\MessagePublished;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use DateTime;

class ChattingController extends Controller
{
    public function sendMessage(Request $request){

        $user= $request->user();

       // $data=$request->all();
        
        
        $message= new Message;
        $message->sender='user';
        $message->user_id=$user->id;
        $message->mentor_id=$user->mentor_id;
        $message->message=$request->message;
        $message->save();
       // event(new AdminNotification());
        event(new MessagePublished($message));
        return 'success';
    }



    public function getMessages(Request $request){

        $user= $request->user();
        $messages=Message::where('mentor_id',$user->mentor_id)
                           ->where('user_id',$user->id)
                           ->get();
                        //   event(new MessagePublished($this->getMessages($request)));

        return $messages;
    }
}
