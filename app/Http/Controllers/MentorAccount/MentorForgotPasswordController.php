<?php

namespace App\Http\Controllers\MentorAccount;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\User;
use App\Notifications\NewPasswordNotification;
use App\Traits\SendToken;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class MentorForgotPasswordController extends Controller
{
    use SendToken;
    public function forgot(Request $request){
        //You can add validation login here
            $user = DB::table('mentors')->where('phone_number', '=', $request->phone_number)
            ->first();
            //Check if the user exists
            if (! $user) {
                return response()->json('user doesn\'t exist');
            }

            DB::table('user_password_resets')->where('phone_number', '=', $request->phone_number)
               ->delete();

            $otp=rand(100000,999999);
            //Create Password Reset Token
            DB::table('user_password_resets')->insert([
            'phone_number' => $request->phone_number,
            'token' => $otp,
            'created_at' => Carbon::now()
            ]);
            //Get the token just created above
            $tokenData = DB::table('user_password_resets')
            ->where('phone_number', $request->phone_number)->first();

            if( $this->sendResetToken($tokenData->token,$request->phone_number)){
               return response()->json('reset code sent',200);
            }
            else {
                    return response()->json('reset code not sent',404);
                 }
    }

    public function verifyResetOtp(Request $request,$token){
        $tokenData = DB::table('user_password_resets')->where('token', $token)->first();

        if (!$tokenData )
        //&& ($tokenData->phone_number != $request->phone_number)
        return response()->json('Invalide token',201);

        $time_to_expire= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',\Carbon\Carbon::now() )->diffInMinutes($tokenData->created_at);
        
        if($time_to_expire > 5){
            return response()->json('The expired token',201);

        }  
      
             return response()->json([
                 'code'=>$token,
                
             ],200);
         
 }  
   
        public function resetPassword(Request $request,$token){
            //Validate input
            $validator = FacadesValidator::make($request->all(), [
               // 'phone_number' => 'required',
                'password' => 'required',
               // 'token' => 'required'
            ]);

            //check if payload is valid before moving on
            if ($validator->fails()) {
                return response()->json(['phone_number' => 'Please complete the form']);
            }

            $password = $request->password;
        // Validate the token
            $tokenData = DB::table('user_password_resets')->where('token', $token)->first();

            $time_to_expire= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',\Carbon\Carbon::now() )->diffInMinutes($tokenData->created_at);
            
            if($time_to_expire > 5){
                return response()->json('expired token',201);

            }
        // Redirect the user back to the password reset request form if the token is invalid
            if (!$tokenData )
            //&& ($tokenData->phone_number != $request->phone_number)
            return response()->json('not valid token',201);

            $user = User::where('phone_number', $tokenData->phone_number)->first();
        // Redirect the user back if the email is invalid
            if (!$user)
            return response()->json('not valid user',201);
            //Hash and update the new password
            $user->password = Hash::make($password);
            $user->update(); //or $user->save();

            //login the user immediately they change password successfully
            //Auth::login($user);

            //Delete the token
            DB::table('user_password_resets')->where('phone_number', $user->phone_number)
            ->delete();
            $access_token=$user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'access_token'=>$access_token,
                   'user'=>$user,
                ],200);
     

}
}
