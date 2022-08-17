<?php

namespace App\Http\Controllers\MentorAccount;

use App\Events\BlogAddedEvent;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Experiance;
use App\Models\Mentor;
use App\Models\User;
use App\Notifications\toAdmin\BlogAdded;
use App\Notifications\toAdmin\MentorRequest;
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
       
        $admin=Employee::where('role','admin')->first();
        $admin->notify(new MentorRequest($mentor));

       $e_data=
       [
       'user'=>$mentor->first_name .$mentor->last_name,
       'type'=>"mentor",
       'title'=>"New Mentor Registerd",
       "id"=>$mentor->id,
       "profile"=>$mentor->profile_picture ? asset('/profilepictures').'/'.$mentor->profile_picture : null,
       'seen'=>0
       ];
           // event(new BlogAddedEvent($e_data));

           return response()->json('succsses',201);

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