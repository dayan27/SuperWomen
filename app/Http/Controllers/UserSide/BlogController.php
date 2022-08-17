<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlogDetailResource;
use App\Http\Resources\User\BlogDetailResource as UserBlogDetailResource;
use App\Http\Resources\User\BlogListResource;
use App\Http\Resources\User\BlogResource;
use App\Http\Resources\User\RelatedBlogResource;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogLike;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function getBlogs(){
     
        $per_page=request()->per_page;
        $query= Blog::where('is_verified',1);

          $query->when(request('filter'),function($query){
           $query = $query->whereHas('fields', function (Builder $query) {
               $query->where('fields.id', '=', request('filter'));
           });
        });
        return BlogListResource::collection($query->paginate($per_page));

    }

     /**
     * get detail of blog
     * 
     */
    public function getBlogDetail($id){
        
         $blog= Blog::find($id);
       
       return new UserBlogDetailResource($blog);
   }

    public function getRecentBlogs(){
        return BlogResource::collection(Blog::where('is_verified',1)->latest()->take(20)->get());
    }
   public function getRelatedBlog($id){
        
        $blog=Blog::find($id);
       $fiels= $blog->fields;

        $blogs=collect();

        foreach ($fiels as $field) {
          $blogs= $blogs->concat( $field->blogs()->where('is_verified',1)->where('blogs.id','!=',$id)->get())->unique();
        }
       // return $blog;
        return RelatedBlogResource::collection( $blogs->values());
    
}

public function addComment(Request $request,$blog_id){

        $user=$request->user();
        $bc= new BlogComment();
        $bc->blog_id=$blog_id;
        $bc->user_id=$user->id;
        $bc->content=$request->comment;
        $bc->save();
        $profile_picture =$user->profile_picture ? asset('/profilepictures').'/'.$user->profile_picture: null;
      //  broadcast(new RoleModelCommented($blog_id,$profile_picture,$bc->content))->toOthers;
 
        return ['id'=>$bc->id,'profile_image'=>$profile_picture,'content'=>$bc->content];
     }
 
 
     public function addLike(Request $request,$blog_id){
       
        
          //   $action = $request->get('action');
             $user=$request->user();
             $blike= new BlogLike();
             $blike->blog_id=$blog_id;
             $blike->user_id=$user->id;
             $blike->save();
 
 
            $blog=Blog::find($blog_id);
            $blog->like+=1;
            $blog->save();
    
     return response()->json(['is_liked'=>1],200);
     }
}
