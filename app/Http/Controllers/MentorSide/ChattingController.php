<?php

namespace App\Http\Controllers\MentorSide;
use App\Http\Controllers\Controller;

use App\Events\AdminNotification;
use App\Events\MentorSendMessage;
use App\Events\MessagePublished;
use App\Events\UserSendMessage;
use App\Http\Resources\Mentor\MenteeChatResource;
use Illuminate\Http\Request;
use App\Models\Message;

class ChattingController extends Controller
{
    public function sendMessage(Request $request){

        // $data=$request->all();
        // $data['sender']='mentor';
        // $data['user_id']=$request->user_id;
        // $data['mentor_id']=$request->user()->id;
        // $message= Message::create($data);

        $message= new Message;
        $message->sender='mentor';
        $message->user_id=$request->user_id;
        $message->mentor_id=$request->user()->id;
        $message->message=$request->message;
        $message->save();
       // event(new MessagePublished($message));
        event(new MentorSendMessage($message));
        return $message;
    }

    public function getMessages(Request $request,$user_id){

        $per_page=$request->per_page ?? 10;

        Message::where('user_id',$user_id)
                         ->where('mentor_id',$request->user()->id)
                         ->update(['seen'=>1]);
                         
        $messages=Message::where('user_id',$user_id)
                         ->where('mentor_id',$request->user()->id)
                         ->orderByDesc('created_at')
                         ->paginate($per_page);

        return $messages;
    }


    public function getChates(){
        $mentor=request()->user();
        return MenteeChatResource::collection($mentor->users);
    }


    public function deleteMessage(Request $request,$id){

       $message= Message::find($id);
                       
       if($message->sender == 'mentor'){
           $message->delete();
           return response()->json('deleted successfully',200);

       }else{
        return response()->json('U have no permission to delete this messgae',403);
  
       }
                        //   event(new MessagePublished($this->getMessages($request)));


    }

    public function editMessage(Request $request,$id){

       $mes= Message::find($id);

       if($mes->sender == 'mentor'){
        $mes->message=$request->message;
        $mes->updated_at=now();
        $mes->save();    
        event(new MentorSendMessage($mes));
  
        return response()->json($mes,200);

       }else{
         return response()->json('U have no permission to edit this messgae',403);

        }


    }
}
