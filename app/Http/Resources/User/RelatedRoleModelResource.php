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
            'image'=>new RoleModelImageResource(RoleModel::find($this->role_model_id)->images()->inRandomOrder()->first()) ?? null,
            'intro'=>RoleModel::find($this->role_model_id)->translate(request('lang'))->intro,
            'created_at'=>RoleModel::find($this->role_model_id)->created_at,
        ];
    }
}
