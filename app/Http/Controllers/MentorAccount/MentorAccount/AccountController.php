<?php
namespace App\Http\Controllers\MentorAccount;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mentor\MenteeResource;
use App\Http\Resources\User\MyInterestResource;
use App\Http\Resources\User\MyMentorResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function myMentees(Request $request){

       return   MenteeResource::collection($request->user()->users);
    }

    public function myExperiances(Request $request){
        return MyInterestResource::collection($request->user()->interests);

    }


}
