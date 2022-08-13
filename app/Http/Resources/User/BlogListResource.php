<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\BlogImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogListResource extends JsonResource
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
            'blog_intro'=>$this->translate(request('lang'))->blog_intro ?? $this->translate()->blog_intro,
            'blog_title'=>$this->translate(request('lang'))->blog_title ?? $this->translate()->blog_title,

            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>count($this->comments),
            //'is_verified'=>$this->is_verified,
            'time_take_to_read'=>$this->time_take_to_read,
            'created_at'=>$this->created_at,
        ];
    }
}
