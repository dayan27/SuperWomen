<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\RoleModelResource;
use App\Models\RoleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RoleModelController extends Controller
{
    public function getRoleModels(){
        $query= RoleModel::query();

               $query=$query->when(request('search'),function($query){
                          
                  $query->where('title','LIKE','%'.request('search').'%')
                        ->orWhere('content','LIKE','%'.request('search').'%');
                  })
                  ->when(request('filter'),function($query){
                    $query = $query->whereHas('fields', function (Builder $query) {
                        $query->where('fields.id', '=', request('filter'));
                    });
                });
                return RoleModelResource::collection($query->latest()->paginate()); 

    }

    public function getRecentRoleModels(){
        return RoleModelResource::collection(RoleModel::latest()->take(20)->get());
    }
    public function addComment(){

    }

    public function addReply(){

    }

    public function addLike($rm_id){
      
       $rm= RoleModel::find($rm_id);
       $rm->like+=1;
    }
}
