<?php

namespace App\Http\Controllers\UserSide;

use App\Events\RoleModelCommented;
use App\Events\RoleModelReacted;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\RelatedRoleModelResource;
use App\Http\Resources\User\RoleModelDetailResource;
use App\Http\Resources\User\RoleModelListResource;
use App\Http\Resources\User\RoleModelResource;
use App\Models\Field;
use App\Models\RoleModel;
use App\Models\RoleModelComment;
use App\Models\RoleModelLike;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RoleModelController extends Controller
{
    // public function getRoleModels(){
    //     $query= RoleModel::query();

    //            $query=$query->when(filled('search'),function($query){
                          
    //               $query->where('title','LIKE','%'.request('search').'%')
    //                     ->orWhere('content','LIKE','%'.request('search').'%');
    //               })
    //               ->when(filled('filter'),function($query){
    //                 $query = $query->whereHas('fields', function (Builder $query) {
    //                     $query->where('fields.id', '=', request('filter'));
    //                 });
    //             });

    //             //
            
    //             return RoleModelResource::collection($query->latest()->paginate()); 

    // }

    public function getRecentRoleModels(){
        return RoleModelResource::collection(RoleModel::latest()->take(20)->get());
    }

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
     * get detail of role model
     * 
     */
    public function getRoleModelDetail($id){
        

         $roleModel= RoleModel::find($id);
        
         //return $roleModel->comments;
        return new RoleModelDetailResource($roleModel);
    }

    /**
     * 
     * 
     */

    public function addComment(Request $request,$role_model_id){

    $user=$request->user();
       $rmc= new RoleModelComment();
       $rmc->role_model_id=$role_model_id;
       $rmc->user_id=$user->id;
       $rmc->content=$request->comment;
       $rmc->save();
       $profile_picture =$user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture: null;
     //  broadcast(new RoleModelCommented($role_model_id,$profile_picture,$rmc->content))->toOthers;

       return ['id'=>$rmc->id,'profile_image'=>$profile_picture,'content'=>$rmc->content];
    }


    public function addLike(Request $request,$role_model_id){
      
       
         //   $action = $request->get('action');
            $user=$request->user();
            $rmlike= new RoleModelLike();
            $rmlike->role_model_id=$role_model_id;
            $rmlike->user_id=$user->id;
            $rmlike->save();


       $rm=RoleModel::find($role_model_id);
        $rm->like+=1;
        $rm->save();

    return response()->json(['is_liked'=>1],200);
    }


    public function getRelatedRoleModels($rm_id){

        $roleModel=RoleModel::find($rm_id);
       $fiels= $roleModel->fields;

        $roleModels=collect();

        foreach ($fiels as $field) {
          $roleModels= $roleModels->concat( $field->role_models()->where('role_models.id','!=',$rm_id)->get() )->unique();
        }
        return RelatedRoleModelResource::collection( $roleModels->values());
    }
}
