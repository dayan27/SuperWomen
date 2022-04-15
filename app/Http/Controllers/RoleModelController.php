<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\RoleModel as AdminRoleModel;
use App\Http\Resources\Admin\RoleModelDetailResource;
use App\Http\Resources\Admin\RoleModelResource;
use App\Models\Blog;
use App\Models\request as ModelsRequest;
use App\Models\RoleModel;
use App\Models\RoleModelImage;
use App\Models\Tag;
use App\ReusedModule\ImageUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class RoleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    //    return RoleModelResource::collection(RoleModel::paginate()); 
        $query= RoleModel::query();

               $query=$query->when(request('search'),function($query){
                          
                  $query->where('title','LIKE','%'.request('search').'%')
                        ->orWhere('content','LIKE','%'.request('search').'%');
                  })
                  ->when(request('filter'),function($query){
                    $query = $query->whereHas('fields', function (Builder $query) {
                        $query->where('fields.id', '=', request('filter'));
                    });
                });
                return RoleModelResource::collection($query->paginate()); 

    }

    public function getTotalData(){
               // return Hash::make('Beza1234');
               $likes=RoleModel::sum('like');
               $shares=RoleModel::sum('share');
               $views=RoleModel::sum('view');
                $count=0;
               foreach (RoleModel::withCount('comments') as $roleModel) {
                   
                 $count+=$roleModel->comments_count;
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
        $request->validate([
            'title'=>'required',
            'content'=>'required',

        ]);

        $data=$request->all();
        // $data['employee_id']=$request->user()->id;
        $data['employee_id']=1;
      //  $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));

        $model=RoleModel::create($data);

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
        $model->fields()->attach($request->interests);
        $model->tags()->attach($tag_ids);

                //calling image upload method from php class

        $iu=new ImageUpload();
        $upload= $iu->multipleImageUpload($request->images,$model->id);
        if (count($upload) > 0) {
        return response()->json($model,201);
        }else{
        return response()->json('error while uploading..',401);
        }
      //  return response()->json($model,201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoleModel  $roleModel
     * @return \Illuminate\Http\Response
     */
    public function show(RoleModel $roleModel)
    {
        return new RoleModelDetailResource($roleModel->load('images','employee'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoleModel  $roleModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoleModel $roleModel)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',

        ]);

        $data=$request->all();
        $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));
        $data['employee_id']=$request->user()->id;
        $roleModel->update($data);

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
        $roleModel->fields()->sync($request->fields);
        $roleModel->tags()->sync($tag_ids);

        return response()->json($roleModel,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoleModel  $roleModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleModel $roleModel)
    {
        $roleModel->tags()->detach();
        $roleModel->fields()->detach();
        $path= public_path().'/rolemodelimages/';
    //    return $post->images;
        foreach ($roleModel->role_model_images as $image) {

            if($image->path && file_exists($path.$image->path)){
              //  return $image->path;
               // Storage::delete('images/'.$image->path);
                unlink($path.$image->path);
            }

            $image->delete();

        }

        $roleModel->delete();
        return response()->json('sucessfully delete',200);

    }

    public function deleteImage($id){

        $image=RoleModelImage::find($id);
        $path= public_path().'/rolemodelimages/';

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
        $upload= $iu->multipleImageUpload($request->images,$request->role_model_id);
        if (count($upload) > 0) {
            return response()->json($upload,201);
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


public function contentImageUpload(){

    try {

      //  return request()->upload;
        $file=request()->upload;
           $name = Str::random(5).time().'.'.$file->extension();
           $file->move(public_path().'/rolemodelimages/', $name);
   

         return response()->json(['url'=>asset('/rolemodelimages').'/'.$name],201);
        } catch (\Throwable $th) {

            return $th;
    }

  }
 
}
