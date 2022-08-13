<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\BlogImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatedBlogResource extends JsonResource
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
            'image'=>new BlogImageResource($this->images()->inRandomOrder()->first()) ?? null,
            'card_image'=>asset('/blogcardimages').'/'.$this->card_image,
            'intro'=>$this->translate(request('lang'))->blog_intro ?? $this->translate()->blog_intro,
            'created_at'=>$this->created_at,
        ];
    }
}
