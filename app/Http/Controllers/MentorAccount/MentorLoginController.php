<?php

namespace App\Http\Controllers\MentorAccount;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Manager;
use App\Models\Mentor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\SendToken;
class MentorLoginController extends Controller
{
    use SendToken;

    public function login(Request $request){

        $request->validate([

            'phone_number'=>'required',
             'password'=>'required',

        ]);

       // return Hash::make('Balew1234');
       // $user_acc=Account::where('user_name',$request->email)->first();
        $mentor=Mentor::where('phone_number',$request->phone_number)->first();

  
        if (! $mentor ) {
            return response()->json([
                'message'=>' incorrect Account',
                ]
               ,404 );
        }

        // if(!$mentor->is_verified){
        //     return response()->json('U are not Verified',404);

        // }

        if(!$mentor->is_accepted){
            return response()->json('U are not approved',404);

        }

        if(!$mentor->is_active){
            return response()->json('U are Blocked',404);

        }



       $check=Hash::check($request->password, $mentor->password);
       if(! $check){
           return response()->json('incorrect credential',404);
       }

        $token=$mentor->createToken('auth_token')->plainTextToken;
       $mentor->profile_picture=$mentor->profile_picture ? asset('/profilepictures').'/'.$mentor->profile_picture :null;
       // return response()->json($Manager,200);
        return response()->json([
            'access_token'=>$token,
            'mentor'=>$mentor,
        ],200);

     }


    public function logout(Request $request){
        //  return  $request->user();
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message'=>$request->user(),
            ],200);

        }
   

        public function changePhoneNumber(Request $request){

           // return $request;
            $request->validate([
                'new_phone_number'=>'required',

            ]);

            $mentor=$request->user();
            if (! $mentor ) {
                return response()->json([
                    'message'=>' undefined Account ',
                    ]
                   ,404 );
            }
      
            $otp=rand(100000,999999);
            $mentor->phone_number=$request->new_phone_number;
            $mentor->verification_code=$otp;
            $mentor->save();
            // Revoke all tokens...
          //  $mentor->tokens()->delete();
            

            $success= $this->sendResetToken($otp,$mentor->phone_number);
            if($success == 'sent'){
                return response()->json('otp sent',201);
            }else{
               return response()->json($success,200);
   
            }
        }


  
    }
  
