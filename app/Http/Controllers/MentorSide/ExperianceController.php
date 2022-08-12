<?php

namespace App\Http\Controllers\MentorSide;
use App\Http\Controllers\Controller;
use App\Models\Experiance;
use App\Models\request as ModelsRequest;
use Illuminate\Http\Request;

class ExperianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentor=request()->user();

        return Experiance::where('mentor_id',$mentor->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mentor=$request->user();
        $data=$request->all();
        $data['mentor_id']=$mentor->id;
        $exp= Experiance::create($data);
        return response()->json($exp,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $experiannce= Experiance::find($id)->update($request->all());
       return response()->json($experiannce,200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Experiance::find($id)->delete();
        return response()->json('deleted successfully',200);

    }
}
