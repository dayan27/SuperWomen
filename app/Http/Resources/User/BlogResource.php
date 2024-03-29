<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\BlogImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            
            'image'=>new BlogImageResource($this->images()->inRandomOrder()->first()) ?? null,
            'card_image'=>asset('/blogcardimages').'/'.$this->card_image,
            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            //'is_verified'=>$this->is_verified,
            'created_at'=>$this->created_at,
        ];
    }
}
