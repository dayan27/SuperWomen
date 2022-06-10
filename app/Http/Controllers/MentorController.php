<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\MentorResource;
use App\Models\Mentor;
use App\Models\MentorRequest;
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
        $query=Mentor::query();

        $query=$query->when(request('search'),function($query){
                          
            $query->where('first_name','LIKE','%'.request('search').'%')
           ->orWhere('last_name','LIKE','%'.request('search').'%');
     })  ->when(request('filter'),function($query){
              
        $query = $query->whereHas('fields', function (Builder $q) {
            $q->where('fields.id', '=', request('filter'));
        });
    });
        return MentorResource::collection(Mentor::paginate(15));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_no'=>'required',
            'biography'=>'required',

         ]);
         return Mentor::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function show(Mentor $mentor)
    {
        return $mentor;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mentor $mentor)
    {

        // $request->validate([
        //     'first_name'=>'required',
        //     'last_name'=>'required',
        //     'phone_no'=>'required',
        //     'biography'=>'required',
        //     'biography'=>'required',




        //  ]);
         return $mentor->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mentor $mentor)
    {
        $mentor->delete();
    }

    public function getMentorRquests(){

       return MentorRequest::where('is_accepeted',0)
                      ->with('mentor')
                       ->get();
    }
    
}
