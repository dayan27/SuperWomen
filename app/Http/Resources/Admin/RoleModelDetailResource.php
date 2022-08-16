<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'id'=>$this->role_model->id,
            'title'=>$this->title,
            'content'=>$this->content,
            'intro'=>$this->intro,
             'images'=> RoleModelImageResource::collection($this->role_model->images) ?? null,
             'view'=>$this->role_model->view,
            'share'=>$this->role_model->share,
            'like'=>$this->role_model->like,
            'comment'=>$this->role_model->comments()->count(),
            'is_verified'=>$this->role_model->is_verified,
            'time_take_to_read'=>$this->role_model->time_take_to_read,
            'written_by'=>$this->role_model->employee()->select('id','first_name','last_name')->first(),
             'tags'=>$this->role_model->tags,
             'fields'=>$this->role_model->fields
        ];
    }
}
