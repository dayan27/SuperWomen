<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ReusedModule\ImageUpload;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Hash::make('12345678');
        return Employee::where('role' ,'!=','admin')->get();
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

        ]);

        $data=$request->all();
        $data['password']=Hash::make($request->last_name.'1234');
        $data['role']='writer';
        $emp= Employee::create($data);
        return response()->json($emp,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return $employee;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());
        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        // $employee->delete();
    }

     public function changeProfilePicture($user_id){

        $employee=Employee::find($user_id);

        $iu=new ImageUpload();
        $name= $iu->profileImageUpload(request('profile'));
        $employee->profile_picture=$name;
        $employee->save();

        $employee->profile_picture=asset('/profilepictures').'/'.$name;
        return response()->json($employee,200);
    }
}