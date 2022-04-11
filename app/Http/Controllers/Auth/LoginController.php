<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request){

        $request->validate([

            'email'=>'required',
            'password'=>'required',

        ]);

        $user=Admin::where('email',$request->email)->first();
        if (! $user ) {
            return response()->json([
                'message'=>' incorrect email and password',
                ]
               ,404 );
        }
        $check=Hash::check($request->password, $user->password);
        if (! $check ) {
            return response()->json([
                'message'=>' incorrect email and password',
                ]
               ,404 );
        }

        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token'=>$token,
            'user'=>$user->load('role'),
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

            $request->validate([
                'old_password'=>'required',
                'new_password'=>'required',

            ]);

            $user=Admin::where('email',$request->user()->email)->first();
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
