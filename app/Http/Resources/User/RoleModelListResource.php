<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\RoleModelImageResource;
use App\Models\RoleModelLike;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleModelListResource extends JsonResource
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
            'card_image'=>$this->card_image ? asset('/rolemodelcardimages').'/'.$this->card_image :null,

            'intro'=>$this->translate(request('lang'))->intro ?? $this->translate()->intro,
            'title'=>$this->translate(request('lang'))->title ?? $this->translate()->intro,
            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            'is_liked'=>$request->isLegal ? (RoleModelLike::where('user_id',$request->isLegal)
            ->where('role_model_id',$this->id)->first() ?1:0) : 0,
            'created_at'=>$this->created_at,
            'is_featured'=>$this->is_featured ?? null,
        ];
    }
}
