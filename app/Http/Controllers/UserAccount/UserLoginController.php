<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Manager;
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



            $otp=rand(1000,9999);

            $user->otp=$otp;
            $user->save();
            $this->sendResetToken($otp,$request->phone_number);
            return response()->json(
                 'otp sent',200 );
        

        $token=$user->createToken('auth_token')->plainTextToken;
      //  $user->profile_picture=asset('/profilepictures').'/'.$user->profile_picture;
       // return response()->json($Manager,200);
        return response()->json([
            'access_token'=>$token,
            'user'=>$user,
        ],200);

     }


    public function logout(Request $request){
        //  return  $request->user();
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message'=>$request->user(),
            ],200);

        }



  
 
        

        public function changePassword(Request $request){

           // return $request;
            $request->validate([
                'old_password'=>'required',
                'new_password'=>'required',

            ]);

            $user=User::where('phone_number',$request->user()->phone_number)->first();
            if (! $user ) {
                return response()->json([
                    'message'=>' incorrect credentials ',
                    ]
                   ,404 );
            }

            $check=Hash::check($request->old_password, $user->password);
            if (! $check ) {
                return response()->json([
                    'message'=>' incorrect old password ',
                    ]
                   ,404 );
            }

            $user->password=Hash::make($request->new_password);
            $user->save();
            return response()->json([
                'message'=>'Successfully  Reset',
                ]
               ,200 );
        }


  
    }
  
