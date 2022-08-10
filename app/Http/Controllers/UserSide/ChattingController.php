<?php

namespace App\Http\Controllers\UserSide;

use App\Events\AdminNotification;
use App\Events\MessagePublished;
use App\Events\UserSendMessage;
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
       // event(new MessagePublished($message));
        //broadcast(new MessagePublished($message))->toOthers();
        event(new UserSendMessage($message));

        return response()->json($message,200);
    }



    public function getMessages(Request $request){

        $user= $request->user();
        $per_page=$request->per_page ?? 10;
        $messages=Message::where('mentor_id',$user->mentor_id)
                           ->where('user_id',$user->id)
                           ->orderByDesc('created_at')
                           ->paginate($per_page);
                        //   event(new MessagePublished($this->getMessages($request)));

        return $messages;
    }

    public function deleteMessage(Request $request,$id){

        Message::find($id)->delete();
                          
                        //   event(new MessagePublished($this->getMessages($request)));

       return response()->json('deleted successfully',200);

    }

    public function editMessage(Request $request,$id){

       $mes= Message::find($id);
       $mes->message=$request->message;
       $mes->updated_at=now();
       $mes->save();

       event(new UserSendMessage($mes));
                 
       return response()->json($mes,200);

    }
}
