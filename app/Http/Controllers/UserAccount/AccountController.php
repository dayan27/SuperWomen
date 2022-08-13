<?php
namespace App\Http\Controllers\UserAccount;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\MyInterestResource;
use App\Http\Resources\User\MyMentorResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function myMentor(Request $request){

       return $request->user()->mentor? new MyMentorResource($request->user()->mentor) :null;
    }

    public function myInterests(Request $request){
        return MyInterestResource::collection($request->user()->interests);

    }

    public function disconnectMentor(){
        $user=request()->user();
         $user->mentor_id=null;
         $user->save();
        return response()->json('disconnected',200);
    }


}
