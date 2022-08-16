<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Employee;
use App\Notifications\SuccessEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request,$token){
            //Validate input
            $validator = Validator::make($request->all(), [
               // 'email' => 'required|email|exists:admins,email',
               // 'password' => 'required',
               // 'token' => 'required'
            ]);

            //check if payload is valid before moving on
            if ($validator->fails()) {
                return response()->json(['email' => 'Please complete the form']);
            }

            $password = $request->password;
        // Validate the token
            $tokenData = DB::table('password_resets')->where('token', $token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
            if (!$tokenData)
            return view('auth.passwords.email');

            $user = Employee::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
            if (!$user)
            return response()->json('not valid user',401);
            //Hash and update the new password
            $user->password = Hash::make($password);
            $user->save(); //or $user->save();

            //login the user immediately they change password successfully
            //Auth::login($user);

            //Delete the token
            DB::table('password_resets')->where('email', $user->email)
            ->delete();

            //Send Email Reset Success Email
            // if ($this->sendSuccessEmail($tokenData->email)) {

                $token=$user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'access_token'=>$token,
                   'user'=>$user,
                ],200);


}

}
