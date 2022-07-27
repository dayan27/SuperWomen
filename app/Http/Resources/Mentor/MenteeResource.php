<?php

namespace App\Http\Resources\Mentor;

use Illuminate\Http\Resources\Json\JsonResource;

class MenteeResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'profile_picture'=>asset('/profilepictures').'/'.$this->profile_picture,
            'education_level'=>$this->education_level,
        
        ];
    }
}
