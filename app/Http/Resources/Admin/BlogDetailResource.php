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
            //'id'=>$this->id,
            'blog_title'=>$this->blog_title,
            'blog_intro'=>$this->blog_intro,
            'blog_content'=>$this->blog_content,
            'images'=> BlogImageResource::collection($this->blog->images) ?? null,
            'view'=>$this->blog->view,
            'share'=>$this->blog->share,
            'like'=>$this->blog->like,
            'comment'=>$this->blog->comments()->count(),
            'tags'=>$this->blog->tags,
            'fields'=>$this->blog->fields,
            'is_verified'=>$this->blog->is_verified,
            'time_take_to_read'=>$this->blog->time_take_to_read,
            'written_by'=>$this->blog->employee()->select('id','first_name','last_name')->first(),
        ];  
      }
}
