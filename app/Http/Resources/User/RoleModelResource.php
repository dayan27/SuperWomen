<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\RoleModelImageResource;
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
            // 'view'=>$this->view,
            // 'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            // 'is_verified'=>$this->is_verified,
        ];
    }
}
