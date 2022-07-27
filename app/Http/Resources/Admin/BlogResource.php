<?php

namespace App\Http\Resources\Admin;

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
            'blog_id'=>$this->id,
            'blog_title'=>$this->title,
            'blog_content'=>$this->content,
            'image'=>new BlogImageResource($this->images()->inRandomOrder()->first()) ?? null,
            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            'is_verified'=>$this->is_verified,
            'created_at'=>$this->created_at,

        ];
    }
}
