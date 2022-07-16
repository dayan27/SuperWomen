<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\RoleModelImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleModelSearchResource extends JsonResource
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
            'image'=>new RoleModelImageResource($this->role_model->images()->inRandomOrder()->first()) ?? null,
            'view'=>$this->role_model->view,
            'share'=>$this->role_model->share,
            'like'=>$this->role_model->like,
            'comment'=>$this->role_model->comments()->count(),
            'is_verified'=>$this->role_model->is_verified,
            'created_at'=>$this->role_model->created_at,

        ];
    }
}
