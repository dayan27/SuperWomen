<?php

namespace App\Http\Controllers\UserSide;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\MyRequestResource;
use App\Models\Request as MentorRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function sendRequest(Request $request,$mentor_id){

        $user=$request->user();
        $men_req=new MentorRequest();
        $men_req->user_id=$user->id;
        $men_req->mentor_id=$mentor_id;
        $men_req->request_message='$request->request_message';
        $men_req->save();

        return response()->json('success',200);
              
    }


    public function myRequests(Request $request){
        return MyRequestResource::collection($request->user()->mentor_requests);

    }
}
