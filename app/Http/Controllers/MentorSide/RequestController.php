<?php

namespace App\Http\Controllers\MentorSide;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mentor\RequestResource;
use App\Models\Request as MentorRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function acceptRequest(Request $request,$req_id){

        $mentor=$request->user();
        $men_req= MentorRequest::find($req_id);


        if($men_req->state !='open'){
            return response()->json('User alreay has mentor',400);

        }     
       $user=User::find($men_req->user_id);

        $men_req->state='accepted';

        $men_req->save();
        $user=User::find($men_req->user_id);
        $user->mentor_id=$mentor->id;
        $user->save();
        //updating other request status
        MentorRequest::where('user_id',$men_req->user_id)
                     ->where('state','open')
                     ->update(['state'=>'closed']);
        return response()->json('success',200);
              
    }

    public function rejectRequest(Request $request,$req_id){

        //$user=$request->user();
        $men_req= MentorRequest::find($req_id);
        $men_req->state='rejected';
        $men_req->save();

        return response()->json('success',200);
              
    }

    public function userRequests(Request $request){
        return RequestResource::collection( $request->user()->user_requests);

    }
}
