<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\ExperianceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'experiances'=> ExperianceResource::collection($this->experiances),
            'fields'=>$this->fields,
            'followers'=>$this->users()->count(),
            'profile_picture'=>  $this->profile_picture ? asset('/profilepictures').'/'.$this->profile_picture: null,
            'is_active'=>$this->is_active,
            'created_at'=>$this->created_at,
        ];
    }
}
