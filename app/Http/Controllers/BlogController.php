<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage;
use App\Models\Tag;
use App\ReusedModule\ImageUpload;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Blog::with(['tags','fields'])
        ->when(request('search'),function($query){

        })
        ->when(request('filter'),function($query){

      })

    ->paginate(20);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'posted_date'=>'required',
            'time_take_to_read'=>'required',

        ]);
        $data=$request->all();
        $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));
        $data['employee_id']=$request->user()->id;

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

        //saving blog images

        //calling image upload method from php class

        $iu=new ImageUpload();
        $upload= $iu->blogMultipleImageUpload($request->images,$blog->id);
        if (count($upload) > 0) {
        return response()->json($blog->load('images'),201);
        }else{
        return response()->json('error while uploading..',401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return $blog;
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
            'posted_date'=>'required',
            'time_take_to_read'=>'required',

        ]);
        $data=$request->all();
        $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));
        $data['employee_id']=$request->user()->id;

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
            foreach ($blog->blog_images as $image) {

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

         //   return $path.$image->path;
            if($image->path && file_exists($path.$image->path)){
             // return true;
                 //Storage::delete('images/'.$image->path);
                 unlink($path.$image->path);
            }

            $image->delete();
            return response()->json('sucessfully deleted',200);


        }

        public function updateImage(Request $request){
            $iu=new ImageUpload();
            $upload= $iu->blogmultipleImageUpload($request->images,$request->blog_id);
            if (count($upload) > 0) {
                return response()->json($upload,201);
            }else{
                return response()->json('error while uploading',401);

            }

        }

    }

