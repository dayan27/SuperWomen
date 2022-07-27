<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RoleModelDetailResource;
use App\Http\Resources\User\RoleModelDetailResource as UserRoleModelDetailResource;
use App\Http\Resources\User\RoleModelListResource;
use App\Http\Resources\User\RoleModelResource;
use App\Models\RoleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RoleModelController extends Controller
{
    /**
     * return a role model data for a home page
     */
    public function getRoleModels(){
        //$roleModel= RoleModel::all();
       // return   RoleModelResource::collection($blog);
        $per_page=request()->per_page;
        $query= RoleModel::query();
       return RoleModelListResource::collection($query->paginate($per_page));

    }
    /**
     * get recently added role model for landing page
     * 
     */

    public function getRecentRoleModels(){
        $roleModel= RoleModel::all();
        return   RoleModelResource::collection($roleModel);
    }
    /**
     * get detail of role model
     * 
     */
    public function getRoleModelDetail($id){
        

         $roleModel= RoleModel::find($id);
        
        return new UserRoleModelDetailResource($roleModel);
    }

    /**
     * 
     * 
     */

    public function addComment(){

    }

    public function addReply(){

    }

    public function addLike($rm_id){
      
       $rm= RoleModel::find($rm_id);
       $rm->like+=1;
    }
}
