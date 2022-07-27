<?php

namespace App\Http\Controllers\UserAccount;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\MyInterestResource;
use App\Models\User;
use App\Traits\SendToken;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    //
    use SendToken;
    public function verifyPhone(Request $request){
        $user=User::where('phone_number',$request->phone_number)->where('otp',$request->otp)->first();
        if($user){
        // return $user;
           $user->otp=null;
           $user->save();
           //$request->session()->put('verified', true);
           $token=$user->createToken('auth_token')->plainTextToken;
             $user->profile_picture=asset('/profilepictures').'/'.$user->profile_picture;
            // return response()->json($Manager,200);

            
             return response()->json([
                 'access_token'=>$token,
                 'user'=>$user,
             ],200);
                 }else{
            return response()->json('Error inValid Otp',401);

        }

    }

    public function resend(Request $request){
        $otp=rand(100000,999999);
        $user=User::where('phone_number',$request->phone_number)->first();
        $user->otp=$otp;
        $user->save();
        $success= $this->sendResetToken($otp,$user->phone_number);
         if($success == 'sent'){
             return response()->json('otp sent',200);
         }else{
            return response()->json($success,400);

         }    
        
        
    }
}
