<?php

namespace App\Http\Resources\User;

use App\Models\Experiance;
use Illuminate\Http\Resources\Json\JsonResource;

class MyMentorResource extends JsonResource
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
            'profile_picture'=>asset('/profilepictures').'/'.$this->profile_picture,
            'no_of_mentee'=>$this->users()->count(),
            'experiances'=>$this->when($request->is('user/*'), function() { 
              return  ExperianceResource::collection($this->experiances);
             }),
             'availablites'=>$this->when($request->is('user/*'), function() { 
             return  VisiblityResource::collection($this->availabilities) ;
            }),
                        

            
        ];
    }
}
