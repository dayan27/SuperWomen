<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperianceResource extends JsonResource
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
            'position'=>$this->position,
            'organization'=>$this->organization,
            'to'=>$this->to,
            'from'=>$this->from,
            'is_current'=>$this->is_current,
            
        ];
    }
}
