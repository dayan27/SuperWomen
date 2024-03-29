<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return  Role::create(['name'=>$request->name]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role=Role::find($id);
        $permissions=$role->permissions;
        $permissionz=[];
        foreach($permissions as $permission){
         $permissionz[]=$permission->id;
        }
        return $permissionz;
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
       return Role::find($id)->update(['name'=>$request->name]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::find($id);
        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();
    }


 /**
     *
     *  assign permission to a certian role
     * 
     */

    public function assignPermissions(Request $request,$role_id){
        $role=Role::find($role_id);
        return $role->syncPermissions($request->permissions);

    }
}
