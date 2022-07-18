<?php

namespace App\Http\Resources\Mentor;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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

            'message'=>$this->pivot->message,
            'seen'=>$this->pivot->seen,
            'created_at'=>$this->pivot->created_at,
        ];
    }
}
