<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailResource extends JsonResource
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
            'title'=>$this->title,
            'content'=>$this->content,
            'images'=> BlogImageResource::collection($this->images) ?? null,
            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            'is_verified'=>$this->is_verified,
            'written_by'=>$this->employee()->select('id','first_name','last_name')->first(),
        ];  
      }
}