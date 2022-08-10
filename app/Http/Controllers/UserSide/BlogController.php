<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlogDetailResource;
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
    public function getBlogDetail($id){
 
        $blog= Blog::find($id);
        
        //return $roleModel->comments;
       return new BlogDetailResource($blog); 
    }

    public function getRecentBlogs(){
        return BlogResource::collection(Blog::latest()->take(20)->get());
    }
    public function addComment(){

    }

    public function addReply(){

    }
}
