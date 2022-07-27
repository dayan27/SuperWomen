<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\RoleModelImageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class RoleModelDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'image'=> RoleModelImageResource::collection($this->images) ?? null,
            'title'=>$this->translate(request('lang'))->title ?? $this->translate()->title,
            'intro'=>$this->translate(request('lang'))->intro ?? $this->translate()->intro,
            'content'=>$this->translate(request('lang'))->content ?? $this->translate()->content,
            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            'audio_path'=>asset('/rolemodelaudio').'/'.$this->audio_path,
           // 'related_role_model'=>DB::table('field_role_model')->where('role_model_id',$this->id)->get(),
            'related_role_models'=>RelatedRoleModelResource::collection(DB::table('field_role_model')->where('field_id',DB::table('field_role_model')->where('role_model_id',$this->id)->first()->field_id)->get()),  
           //'cc'=>$this->comments,
            'comments'=>CommentResource::collection($this->comments), 

            
            //'is_verified'=>$this->is_verified,
            'created_at'=>$this->created_at,
            // return [
        //     'id'=>$this->id,
        //     'path'=>asset('/rolemodelimages').'/'.$this->image_path,
        // ];
        ];
    }
}
