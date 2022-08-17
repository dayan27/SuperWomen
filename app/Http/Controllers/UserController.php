<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\request as ModelsRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query= User::query();
   
        $query=$query->when(request('search'),function($query){
                   
           $query->where('first_name','LIKE','%'.request('search').'%')
                 ->orWhere('last_name','LIKE','%'.request('search').'%');
           })
           ->when(request('filter'),function($query){
              
             $query = $query->whereHas('fields', function (Builder $q) {
                 $q->where('fields.id', '=', request('filter'));
             });
         });
         $users= $query->with('education_level','fields','mentor')->paginate(); 

         $users->map(function($user){
           return $user->profile_picture = $user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture: null;

         });

         return $users;

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
            'date_of_birth'=>'required',
            'education_level'=>'required',
            'password'=>'required',
        ]);
        $data=$request->all();
        $data['date_of_birth']=date('Y-m-d',strtotime($request->date_of_birth));
        return User::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
         $user->update($request->all());
         return $user;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
       $user->delete();
    }

    public function changeUserState($user_id){

       $user= User::find($user_id);
       $user->is_active=request('state');
       $user->save();

       return response()->json($user->is_active,200);
    }




}
