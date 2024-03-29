<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Events\AdminNotification;
use App\Events\BlogAddedEvent;
use App\Http\Resources\Admin\BlogDetailResource;
use App\Http\Resources\Admin\BlogResource;
use App\Http\Resources\BlogSearchResource;
use App\Models\Blog;
use App\Models\BlogImage;
use App\Models\BlogTranslation;
use App\Models\Employee;
use App\Models\request as ModelsRequest;
use App\Models\RoleModel;
use App\Models\Tag;
use App\Notifications\toAdmin\BlogAdded;
use App\ReusedModule\ImageUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class BlogController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page=request('per_page');
        $query= Blog::query();

        $query=$query->when(request('search'),function($query){

           $query->where('title','LIKE','%'.request('search').'%')
                 ->orWhere('content','LIKE','%'.request('search').'%');
           })
           ->when(request('filter'),function($query){
            $query = $query->whereHas('fields', function (Builder $query) {
                $query->where('fields.id', '=', request('filter'));
            });
         });
         return BlogResource::collection($query->paginate($per_page));

    }
     /**
     * search rolemodel
     */
    
    public function search(){
        $per_page=request()->per_page;

        $query=BlogTranslation::query();
        $query=$query->when(request('search'),function($query){

            $query->where('blog_title','LIKE','%'.request('search').'%')
                        ->orWhere('blog_content','LIKE','%'.request('search').'%')
                        ->orWhere('blog_intro','LIKE','%'.request('search').'%');
            });
            return BlogSearchResource::collection($query->paginate($per_page));
    }


    public function getTotalData(){
        // return Hash::make('Beza1234');
        $likes=Blog::sum('like');
        $shares=Blog::sum('share');
        $views=Blog::sum('view');
         $count=0;
        foreach (Blog::withCount('comments') as $blog) {

          $count+=$blog->comments_count;
        }


        return response()->json([
            'likes'=>$likes,
            'shares'=>$shares,
            'views'=>$views,
            'comments'=>$count
        ],200);
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


       // return $request->title;
        $request->validate([
            'blog_title'=>'required',
            'blog_content'=>'required',
            'blog_intro'=>'required',
            'time_take_to_read'=>'required',

        ]);

        // try {
        //     DB::beginTransaction();

            $data=$request->all();
            // $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));
             $data['employee_id']=$request->user()->id;
        //    $data['employee_id']=1;
           // return $data;
            $blog=Blog::create($data);  //creating blog

            // collecting tag ids
            $tags=$request->tags;
            $tag_ids=[];
            foreach ($tags as $splited) {
                $check=Tag::where('title',$splited)->first();
                if ($check) {
                    $tag_ids[]=$check->id;
                }else {
                    $tag=new Tag();
                    $tag->title=$splited;
                    $tag->save();
                    $tag_ids[]=$tag->id;

                }

            }
            $blog->tags()->attach($tag_ids); //attaching blog with tags
            $blog->fields()->attach($request->interests);

            //saving blogcard 
            if($request->card_image){
                $file=$request->card_image;
                $name = Str::random(5).time().'.'.$file->extension();
                $file->move(public_path().'/blogcardimages/', $name);
                $blog->card_image = $name;
                $blog->save();
            }
    

            //saving blog images

            //calling image upload method from php class

            $iu=new ImageUpload();
            $upload= $iu->blogMultipleImageUpload($request->images,$blog->id);
            if (count($upload) > 0) {

                if($request->user()->role != 'admin'){
                $admin=Employee::where('role','admin')->first();
                $admin->notify(new BlogAdded($blog));
                }

               $e_data= 
               [
                'user'=>request()->user()->first_name.' ' . request()->user()->first_name,
                'type'=>"blog",
                'title'=>"New Blog Created",
                 "id"=>$blog->id,
                 'seen'=>0
              ];

                event(new BlogAddedEvent($e_data));
                DB::commit();
            return response()->json($blog,201);
            }else{
            return response()->json('error while uploading..',401);
            }



        // } catch (\Throwable $th) {

        //     DB::rollBack();
        //     return $th;
        // }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        
        $blogTrans=$blog->translate(request('lang'));
        if(!$blogTrans){
            return 'no data';
        }
        return new BlogDetailResource($blogTrans);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {

        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'time_take_to_read'=>'required',

        ]);
        $data=$request->all();
        // $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));
        $data['employee_id']=1;

        $blog->update($data);  //creating blog

        // collecting tag ids
        $tags=$request->tags;
        $tag_ids=[];
        foreach ($tags as $splited) {
            $check=Tag::where('title',$splited)->first();
            if ($check) {
                $tag_ids[]=$check->id;
            }else {
                $tag=new Tag();
                $tag->title=$splited;
                $tag->save();
                $tag_ids[]=$tag->id;

            }

        }
        $blog->tags()->sync($tag_ids); //attaching blog with tags

        return $blog;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {

        $blog->tags()->detach();
        $path= public_path().'/blogimages/';
        //    return $post->images;
            foreach ($blog->images as $image) {

                if($image->path && file_exists($path.$image->path)){
                  //  return $image->path;
                   // Storage::delete('images/'.$image->path);
                    unlink($path.$image->path);
                }

                $image->delete();

            }

            $blog->delete();
            return response()->json('sucessfully delete',200);

        }

        public function deleteImage($id){

            $image=BlogImage::find($id);
            $path= public_path().'/blogimages/';
            if($image->path && file_exists($path.$image->path)){

                 unlink($path.$image->path);
            }

            $image->delete();
            return response()->json('sucessfully deleted',200);

        }

        public function updateImage(Request $request,$blog_id){
            $iu=new ImageUpload();
            $upload= $iu->blogmultipleImageUpload($request->images,$blog_id);
            if (count($upload) > 0) {
                return response()->json($upload,200);
            }else{
                return response()->json('error while uploading',401);
            }

        }

        public function verify($id){

            $blog=Blog::find($id);
            $blog->is_verified=1;
            $blog->save();
            return response()->json('verified',200);
        }

    }

