<?php

namespace App\Http\Controllers\MentorAccount;

use App\Http\Controllers\Controller;
use App\Models\Experiance;
use App\Models\Mentor;
use App\Models\User;
use App\Traits\SendToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MentorRegistrationController extends Controller
{
    use SendToken;
    public function register(Request $request){
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_number'=>'required',
            'date_of_birth'=>'required',
            'email'=>'required',
        ]);
       
        $data=$request->all();
        $data['password']=Hash::make($request->last_name.'1234');
        $data['date_of_birth']=date('Y-m-d',strtotime($request->date_of_birth));
        $user= Mentor::create($data);
       
        return response()->json('Registered !!!! waite while admin contact u',201);

        // $otp=rand(100000,999999);

        // $user->otp=$otp;
        // $user->save();
        // $success= $this->sendResetToken($otp,$user->phone_number);
        //  if($success){
        //      return response()->json('otp sent',201);
        //  }else{
        //     return response()->json($success,200);

        //  }
    }

    public function addMentorExperiance(Request $request, $mentor_id){

        $mentor=$request->user();
        $data=$request->all();
        $data['mentor_id']=$mentor->id;
        Experiance::create($data);
        return response()->json('succsses',200);
    }


    public function updateProfile(Request $request){

        $mentor=$request->user();
        $mentor->update($request->all());
        return $mentor;
    }
}