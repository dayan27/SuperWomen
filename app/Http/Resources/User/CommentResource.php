<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content'=>$this->pivot ? $this->pivot->content :null,
           // 'pp'=>$this->profile_picture,
           'profile_image'=>  $this->profile_picture ? asset('/profilepictures').'/'.$this->profile_picture: null,
           // 'image'=>new RoleModelImageResource(RoleModel::find($this->role_model_id)->images()->inRandomOrder()->first()) ?? null,
            // 'intro'=>RoleModel::find($this->role_model_id)->translate(request('lang'))->intro,
            // 'created_at'=>RoleModel::find($this->role_model_id)->created_at,
        ];
    }
}
