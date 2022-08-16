<?php

namespace App\Http\Resources\Mentor;

use Illuminate\Http\Resources\Json\JsonResource;

class MenteeChatResource extends JsonResource
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
            'profile_picture'=>$this->profile_picture ? asset('/profilepictures').'/'.$this->profile_picture : null,
            'message'=>new MessageResource($this->messages()->orderByDesc('messages.created_at')->first()),
             'no'=>$this->messages()->wherePivot('seen',0)->count()
        ];
    }
}
