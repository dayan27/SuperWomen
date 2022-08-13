<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\RoleModelImageResource;
use App\Models\RoleModel;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatedRoleModelResource extends JsonResource
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
            'card_image'=>asset('/blogcardimages').'/'.$this->card_image,
            'intro'=>$this->translate(request('lang'))->intro ?? $this->translate()->intro,
            'created_at'=>$this->created_at,
        ];
    }
}
