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

        // $messages=Message::where('user_id',$user_id)
        //                  ->where('mentor_id',$request->mentor_id)
        //                  ->get();

      //  return $request->user()->id;
        $messages=Message::where('user_id',$request->user()->id)
                         ->where('mentor_id',$request->user()->mentor_id)
                         ->get();

        return $messages;
    }
}
