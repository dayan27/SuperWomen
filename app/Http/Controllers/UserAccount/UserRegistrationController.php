<?php

namespace App\Http\Controllers\UserAccount;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\ReusedModule\ImageUpload;
use App\Traits\SendToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserRegistrationController extends Controller
{
    use SendToken;
    public function registerUser(Request $request){
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_number'=>'required',
            'date_of_birth'=>'required',
            'education_level_id'=>'required',
        ]);
        $data=$request->all();
        $data['date_of_birth']=date('Y-m-d',strtotime($request->date_of_birth));
        $user= User::create($data);
       
        $otp=rand(100000,999999);

        $user->otp=$otp;
        $user->save();
        //////////shoud be removed after testing
        return response()->json('otp sent',201);

        $success= $this->sendResetToken($otp,$user->phone_number);
         if($success == 'sent'){
             return response()->json('otp sent',201);
         }else{
            return response()->json($success,401);

         }
    }

    public function addUserInterest(Request $request){

        $user=$request->user();
        $user->interests()->sync($request->interests);
        return response()->json('succsses',200);
    }


    public function updateProfile(Request $request){

        $user=$request->user();
        $user->update($request->except('profile_picture'));
       $user->profile_picture= $user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture :null;

        return $user;
    }

    public function changeProfilePicture(Request $request){

        $user=$request->user();
        
        $path= public_path().'/profilepictures/';
    
                if(($user->profile_picture) && file_exists($path.$user->profile_picture)){
             
                    unlink($path.$user->profile_picture);
                }

              //  $user->profile_picture='';

            

        $iu=new ImageUpload();
        $name= $iu->profileImageUpload(request('profile'));
        $user->profile_picture=$name;
        $user->save();
        $user->profile_picture=$user->profile_picture? asset('/profilepictures').'/'.$user->profile_picture : null;

       // $user->profile_picture=asset('/profilepictures').'/'.$name;
        return response()->json($user,200);
    }

}