<?php

namespace App\Http\Controllers\MentorSide;
use App\Http\Controllers\Controller;

use App\Events\AdminNotification;
use App\Events\MessagePublished;
use App\Http\Resources\Mentor\MenteeChatResource;
use Illuminate\Http\Request;
use App\Models\Message;

class ChattingController extends Controller
{
    public function sendMessage(Request $request){

        $data=$request->all();
        $data['sender']='mentor';
        $data['user_id']=$request->user_id;
        $data['mentor_id']=$request->user()->id;
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
        $messages=Message::where('user_id',$request->user_id)
                         ->where('mentor_id',$request->user()->id)
                         ->get();

        return $messages;
    }


    public function getChates(){
        $mentor=request()->user();
        return MenteeChatResource::collection($mentor->users);
    }
}
