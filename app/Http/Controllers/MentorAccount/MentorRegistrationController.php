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
        $data['profile_picture']='default.jpg';
        
        $mentor= Mentor::create($data);
       

        $otp=rand(100000,999999);

        $mentor->verification_code=$otp;
        $mentor->save();

        

        $success= $this->sendResetToken($otp,$mentor->phone_number);
        if($success == 'sent'){
            return response()->json('Registered !!!!verify ur phone otp sent',201);
        }else{
           return response()->json($success,200);

        }
    }

    public function addMentorExperiance(Request $request){

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