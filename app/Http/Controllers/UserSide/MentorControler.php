<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MentorDetailResource;
use App\Http\Resources\Admin\MentorResource;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MentorControler extends Controller
{
    public function getMentors(){


        $query= Mentor::query();

        $query=$query->when(request('search'),function($query){
                   
           $query->where('first_name','LIKE','%'.request('search').'%')
                 ->orWhere('last_name','LIKE','%'.request('search').'%');
           })
           ->when(request('filter'),function($query){
             $query = $query->whereHas('fields', function (Builder $query) {
                 $query->where('fields.id', '=', request('filter'));
             });
         });
         return MentorResource::collection($query->paginate()); 

    }

    public function sendMentorRequest($mentor_id){

        $mentor= Mentor::find($mentor_id);
        $mentor->user_requests()->attach($mentor_id);
    }

    public function viewMentor($mentor_id){

        return new MentorDetailResource(Mentor::find($mentor_id));
    }
}