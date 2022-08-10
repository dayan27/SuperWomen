<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\RoleModelImageResource;
use App\Models\RoleModelLike;
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
        //    'related_role_model'=>DB::table('blog_field')->where('field_id',$this->id)->get(),
     
           //'cc'=>$this->comments,
            'comments'=>CommentResource::collection($this->comments), 
            'is_liked'=>$request->isLegal ? (RoleModelLike::where('user_id',$request->isLegal)
            ->where('role_model_id',$this->id)->first() ?1:0) : 0,


            //'is_verified'=>$this->is_verified,
            'created_at'=>$this->created_at,
            // return [
        //     'id'=>$this->id,
        //     'path'=>asset('/rolemodelimages').'/'.$this->image_path,
        // ];
        ];
    }
}
