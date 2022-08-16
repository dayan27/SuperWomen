<?php

namespace App\Http\Controllers\UserAccount;

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
class UserLoginController extends Controller
{
    use SendToken;

    public function login(Request $request){

        $request->validate([

            'phone_number'=>'required',
            // 'password'=>'required',

        ]);

       // $user_acc=Account::where('user_name',$request->email)->first();
        $user=User::where('phone_number',$request->phone_number)->first();
        if (! $user ) {
            return response()->json([
                'message'=>' incorrect Account',
                ]
               ,404 );
        }



            $otp=rand(100000,999999);

            $user->otp=$otp;
            $user->save();

            

            $success= $this->sendResetToken($otp,$user->phone_number);
            if($success == 'sent'){
                return response()->json('otp sent',201);
            }else{
               return response()->json($success,200);
   
            }


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

            $user=$request->user();
            if (! $user ) {
                return response()->json([
                    'message'=>' undefined user ',
                    ]
                   ,404 );
            }
      
            $otp=rand(100000,999999);
            $user->phone_number=$request->new_phone_number;
            $user->otp=$otp;
            $user->save();
            // Revoke all tokens...
           // $user->tokens()->delete();
            

            $success= $this->sendResetToken($otp,$user->phone_number);
         
            if($success == 'sent'){
                return response()->json('otp sent',201);
            }else{
               return response()->json($success,401);
   
            }
        }


        public function getLoginUser(){
            //return Hash::make('12345678');
            //$data='helloplease work  hard';
            $user=request()->user();
            $user->profile_picture=$user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture :null;

            if($user->mentor_id){
               $mentor=Mentor::find($user->mentor_id)->first();
                       $user->mentor_first_name=$mentor->first_name;
                       $user->mentor_last_name=$mentor->last_name;
            }else{
                $user->mentor_first_name=null;
                $user->mentor_last_name=null;                
            }
           
            return $user;
        }
    }
  
