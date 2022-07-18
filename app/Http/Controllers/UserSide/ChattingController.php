<?php

namespace App\Http\Controllers\UserSide;

use App\Events\AdminNotification;
use App\Events\MessagePublished;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;

class ChattingController extends Controller
{
    public function sendMessage(Request $request){

        $data=$request->all();
        $data['sender']='user';
        $message= Message::create($data);
       // event(new AdminNotification());
        event(new MessagePublished($message));
        return $message;
    }



    public function getMessages(Request $request){

        $user= $request->user();
        $messages=Message::where('mentor_id',$user->mentor_id)
                           ->where('user_id',$user->id)
                           ->get();

        return $messages;
    }
}
