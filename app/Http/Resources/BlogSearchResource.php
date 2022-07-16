<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\BlogImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogSearchResource extends JsonResource
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
            'blog_title'=>$this->blog_title,
            'blog_intro'=>$this->blog_intro,
            'blog_content'=>$this->blog_content,
           'image'=>new BlogImageResource($this->blog->images()->inRandomOrder()->first()) ?? null,
            'view'=>$this->blog->view,
            'share'=>$this->blog->share,
            'like'=>$this->blog->like,
            'comment'=>$this->blog->comments()->count(),
            'is_verified'=>$this->is_verified,
            'created_at'=>$this->created_at,

        ];
    }
}
