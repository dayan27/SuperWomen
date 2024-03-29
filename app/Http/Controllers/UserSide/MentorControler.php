<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MentorDetailResource;
use App\Http\Resources\Admin\MentorResource;
use App\Http\Resources\User\MyMentorResource;
use App\Models\Mentor;
use App\Models\request as ModelsRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MentorControler extends Controller
{
    public function getMentors(){


        $query= Mentor::query();
        
        $query=$query->where('is_accepted',1)->where('is_active',1);

        $query=$query
           ->when(request('filter'),function(Builder $query){
                 $query->where('field_id', '=', request('filter'));
             
         });

         
         return MyMentorResource::collection($query->paginate()); 

    }

    // public function sendMentorRequest($mentor_id){

    //     $mentor= Mentor::find($mentor_id);
    //     $mentor->user_requests()->attach(request()->user()->id);
    // }

    public function viewMentor($mentor_id){

        return new MentorDetailResource(Mentor::find($mentor_id));
    }
}
