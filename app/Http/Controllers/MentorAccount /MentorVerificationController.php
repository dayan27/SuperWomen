<?php

namespace App\Http\Controllers\MentorAccount;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\User;
use App\Traits\SendToken;
use Illuminate\Http\Request;

class MentorVerificationController extends Controller
{
    //
    use SendToken;
    public function verifyPhone(Request $request){
        $user=Mentor::where('phone_number',$request->phone_number)->where('verification_code',$request->otp)->first();
        if($user){
        // return $user;
           $user->otp=null;
           $user->save();
           //$request->session()->put('verified', true);
           $token=$user->createToken('auth_token')->plainTextToken;
             $user->profile_picture=asset('/profilepictures').'/'.$user->profile_picture;

             return response()->json([
                 'access_token'=>$token,
                 'user'=>$user,
             ],200);
                 }else{
            return response()->json('Error inValid Otp',401);

        }

    }

    public function resend(Request $request){
        $otp=rand(1000,9999);
        $user=Mentor::where('phone_number',$request->phone_number)->first();
        $user->otp=$otp;
        $user->save();
        $success= $this->sendResetToken($otp,$user->phone_number);
         if($success == 'sent'){
             return response()->json('otp sent',201);
         }else{
            return response()->json($success,200);

         }    
        
        
    }
}
