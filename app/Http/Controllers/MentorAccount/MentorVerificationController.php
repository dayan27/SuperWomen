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
        $mentor=Mentor::where('phone_number',$request->phone_number)->where('verification_code',$request->code)->first();
        if($mentor){
        // return $mentor;
        $mentor->verification_code=null;
        $mentor->is_verified=1;
        $mentor->save();
           //$request->session()->put('verified', true);
           $token=$mentor->createToken('auth_token')->plainTextToken;
             $mentor->profile_picture=asset('/profilepictures').'/'.$mentor->profile_picture;

             return response()->json([
                 'access_token'=>$token,
                 'mentor'=>$mentor,
             ],200);
                 }else{
            return response()->json('Error inValid verification_code',401);

        }

    }

    public function resend(Request $request){
        $verification_code=rand(1000,9999);
        $user=Mentor::where('phone_number',$request->phone_number)->first();
        $user->verification_code=$verification_code;
        $user->save();
        $success= $this->sendResetToken($verification_code,$user->phone_number);
         if($success == 'sent'){
             return response()->json('verification_code sent',201);
         }else{
            return response()->json($success,200);

         }    
        
        
    }
}
