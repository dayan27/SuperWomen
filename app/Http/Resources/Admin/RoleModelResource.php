<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleModelResource extends JsonResource
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
            'image'=>new RoleModelImageResource($this->images()->inRandomOrder()->first()) ?? null,
            'card_image'=> $this->card_image ? asset('/rolemodelcardimages').'/'.$this->card_image :null,
            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            'is_verified'=>$this->is_verified,
            'created_at'=>$this->created_at,

        ];
    }
}
