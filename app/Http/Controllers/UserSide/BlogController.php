<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlogDetailResource;
use App\Http\Resources\User\BlogDetailResource as UserBlogDetailResource;
use App\Http\Resources\User\BlogListResource;
use App\Http\Resources\User\BlogResource;
use App\Http\Resources\User\RelatedBlogResource;
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
     /**
     * get detail of blog
     * 
     */
    public function getBlogDetail($id){
        
         $blog= Blog::find($id);
       
       return new UserBlogDetailResource($blog);
   }

   public function getRelatedBlog($id){
        
        $blog=Blog::find($id);
       $fiels= $blog->fields;

        $blogs=collect();

        foreach ($fiels as $field) {
          $blogs= $blogs->concat( $field->blogs()->where('blogs.id','!=',$id)->get())->unique();
        }
       // return $blog;
        return RelatedBlogResource::collection( $blogs->values());
    
}

    public function addComment(){

    }

    public function addReply(){

    }
}
