<?php

namespace App\Http\Resources\Admin;

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
            'field'=>$this->fields()->inRandomOrder()->first(),
            'followers'=>$this->users()->count(),
            'profile_picture'=>$this->profile_picture,
            'is_active'=>$this->is_active,
            'created_at'=>$this->created_at,
        ];
    }
}
