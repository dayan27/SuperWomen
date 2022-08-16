<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\ExperianceResource;
use App\Http\Resources\User\VisiblityResource;
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
            'email'=>$this->email,
            'phone_number'=>$this->phone_number,
            'experiances'=> ExperianceResource::collection($this->experiances),
            'field_id'=>$this->field_id,
            'followers'=>$this->users()->count(),
            'profile_picture'=>  $this->profile_picture ? asset('/profilepictures').'/'.$this->profile_picture: null,
            'is_active'=>$this->is_active,
            'is_accepted'=>$this->is_accepted,
            'availablites'=>VisiblityResource::collection($this->availabilities),
            'created_at'=>$this->created_at,
            'date_of_birth'=>$this->date_of_birth,
            'bio'=>$this->bio,
            'location'=>'Bahir dar',
        ];
    }
}
