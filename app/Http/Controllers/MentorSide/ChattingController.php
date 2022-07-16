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
        $data['sender']='mentor';
        $data['user_id']=$request->user()->id;
        $data['mentor_id']=$request->user()->mentor_id;
        $message= Message::create($data);
       // event(new AdminNotification());
        event(new MessagePublished($message));
        return $message;
    }
}
