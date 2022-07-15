<?php

namespace App\Http\Controllers\UserAccount;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\SendToken;
use Illuminate\Http\Request;

class UserRegistrationController extends Controller
{
    use SendToken;
    public function registerUser(Request $request){
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_number'=>'required',
            'date_of_birth'=>'required',
            'education_level'=>'required',
        ]);
        $data=$request->all();
        $data['date_of_birth']=date('Y-m-d',strtotime($request->date_of_birth));
        $user= User::create($data);
       
        $otp=rand(100000,999999);

        $user->otp=$otp;
        $user->save();
        $success= $this->sendResetToken($otp,$user->phone_number);
         if($success){
             return response()->json('otp sent',201);
         }else{
            return response()->json('otp not sent',200);

         }
    }

    public function addUserInterest(Request $request, $user_id){

        $user=User::find($user_id);
        $user->interests()->sync($request->interests);
        return response()->json('succsses',200);
    }
}