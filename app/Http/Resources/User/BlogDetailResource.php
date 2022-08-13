<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\BlogImageResource;
use App\Models\BlogLike;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
           // 'related_role_model'=>'hii',
           // DB::table('blog_field')->where('field_id',$this->id)->get(),

            'image'=> new BlogImageResource($this->images->first()) ?? null,
            'blog_title'=>$this->translate(request('lang'))->title ?? $this->translate()->blog_title,
            'blog_intro'=>$this->translate(request('lang'))->intro ?? $this->translate()->blog_intro,
            'blog_content'=>$this->translate(request('lang'))->content ?? $this->translate()->blog_content,
            'view'=>$this->view,
            'share'=>$this->share,
            'like'=>$this->like,
            'comment'=>$this->comments()->count(),
            'comments'=>CommentResource::collection($this->comments),
            'fields'=>$this->fields,

           // 'blog_field' 
            'is_liked'=>$request->isLegal ? ( BlogLike::where('user_id',$request->isLegal)
           ->where('blog_id',$this->id)->first() ?1:0) : 0,

            'created_at'=>$this->created_at,
            'time_to_read'=>$this->time_take_to_read,

        ];
    }
}
