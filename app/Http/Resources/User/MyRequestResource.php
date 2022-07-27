<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class MyRequestResource extends JsonResource
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
            //'request_message'=>$this->request_message,
            'mentor'=>$this->full_name,
            'state'=>$this->pivot->state,
            'request_message'=>$this->pivot->request_message,
            'created_at'=>$this->pivot->created_at,
        ];
    }
}
