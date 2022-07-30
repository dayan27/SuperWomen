<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\BlogListResource;
use App\Http\Resources\User\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function getBlogs(){
     
        $per_page=request()->per_page;
        $query= Blog::query();
        return BlogListResource::collection($query->paginate($per_page));

    }
    public function getRecentBlogs(){
        $blog= Blog::all();
        return  BlogResource::collection($blog);  
    }

    public function addComment(){

    }

    public function addReply(){

    }
}
