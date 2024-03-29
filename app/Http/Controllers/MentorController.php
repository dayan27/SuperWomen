<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\MentorResource;
use App\Models\Mentor;
use App\Models\MentorRequest;
use App\Models\request as ModelsRequest;
use App\Notifications\MentorAcceptance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $per_page=request('per_page');
        $query=Mentor::query();
    
        $query=$query->when(filled('search'),function($query){
                          
          return $query->where('first_name','LIKE','%'.request('search').'%')
           ->orWhere('last_name','LIKE','%'.request('search').'%');
     });

        
  
        return MentorResource::collection($query->where('is_accepted',1)->where('field_id',request('filter'))
        ->paginate(10));
    }


    public function destroy(Mentor $mentor)
    {
        $mentor->delete();
    }

    public function acceptMentorRequest($id){

       $mentor= Mentor::find($id);
       
       $mentor->is_accepted=1;
       $mentor->save();
      // $mentor->notify(new MentorAcceptance());
        return response()->json($mentor->is_accepted,200);
      
    }

    public function changeMentorStatus(Request $request,$id){

        $mentor=Mentor::find($id);
        $mentor->is_active=$request->status;
        $mentor->save();
        return response()->json($mentor->is_active,200);


    }

    public function getMentorRequests(){
       $mentors= Mentor::where('is_accepted',0)->get();
       return MentorResource::collection($mentors);

    }
    
}
