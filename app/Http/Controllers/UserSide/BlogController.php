<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlogResource;
use App\Http\Resources\User\BlogListResource;
use App\Http\Resources\User\BlogResource as UserBlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /***
     * 
     * 
     */
    public function getBlogs(){
     
        $per_page=request()->per_page;
        $query= Blog::query();
        return BlogListResource::collection($query->paginate($per_page));

    }
    /**
     * get featured or reccently added blog
     */
    public function getRecentBlogs(){
        $blog= Blog::all();
        return  UserBlogResource::collection($blog);  
    }
    /**
     * 
     * 
     */
    public function addComment(){

    }

    public function addReply(){

    }
}
