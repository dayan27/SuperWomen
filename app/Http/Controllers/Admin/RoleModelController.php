<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Events\AdminNotification;
use App\Events\BlogAddedEvent;
use App\Http\Resources\Admin\RoleModel as AdminRoleModel;
use App\Http\Resources\Admin\RoleModelDetailResource;
use App\Http\Resources\Admin\RoleModelResource;
use App\Http\Resources\RoleModelSearchResource;
use App\Models\Blog;
use App\Models\Employee;
use App\Models\request as ModelsRequest;
use App\Models\RoleModel;
use App\Models\RoleModelImage;
use App\Models\RoleModelTranslation;
use App\Models\Tag;
use App\Notifications\NewNotification;
use App\Notifications\toAdmin\RoleModelAdded;
use App\ReusedModule\ImageUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
       $per_page=request('per_page');

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
                return RoleModelResource::collection($query->paginate($per_page));

    }
    /**
     * search rolemodel
     */
    
    public function search(){
        $per_page=request()->per_page;

        $query=RoleModelTranslation::query();
        $query=$query->when(request('search'),function($query){

            $query->where('title','LIKE','%'.request('search').'%')
                        ->orWhere('content','LIKE','%'.request('search').'%')
                        ->orWhere('intro','LIKE','%'.request('search').'%');
            });
            return RoleModelSearchResource::collection($query->paginate($per_page));
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

     //$request->all();
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'intro'=>'required',

        ]);

        // try {
        //     DB::beginTransaction();


        $data=$request->all();
        // $data;
        $data['employee_id']=$request->user()->id;
        // $data['employee_id']=1;
      //  $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));

      // saving a card image for rolemodel
      if($request->card_image){
        $file=$request->card_image;
        $name = Str::random(5).time().'.'.$file->extension();
        $file->move(public_path().'/rolemodelcardimages/', $name);
       // $model->card_image = $name;
       // $model->save();
    }

    $data['card_image']=$name;

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

        //audio file saving 

        if($request->audio_path){
            // return 'a';
            $audio=$request->file('audio_path');
            $name = Str::random(5).time().'.'.$audio->extension();
            $audio->move(public_path().'/rolemodelaudios/', $name);
           
            //$image->refresh();
            //$img['id'] = $image->id;
            $model->audio_path = $name;
            $model->save();
        }
    

  
      //calling image upload method from php class
      $model->audio_path = $model->audio_path? asset('/rolemodelaudios').'/'.$model->audio_path: null;
      $model->card_image = $model->card_image? asset('/rolemodelcardimages').'/'.$model->card_image: null;

        $iu=new ImageUpload();
        $upload= $iu->multipleImageUpload($request->images,$model->id);
        if (count($upload) > 0) {

            if($request->user()->role != 'admin'){
            $admin=Employee::where('role','admin')->first();
            $admin->notify(new RoleModelAdded($model));
            }
            $e_data=
             [
                'user'=>request()->user()->first_name.' ' . request()->user()->first_name,
                'type'=>"rolemodel",
                'title'=>"New Role Model Created",
                 "id"=>$model->id,
                 'seen'=>0
            ];

           // event(new BlogAddedEvent($e_data));
            DB::commit();

            //retriving audio path
         return response()->json($model,201);
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
     * @param  \App\Models\RoleModel  $roleModel
     * @return \Illuminate\Http\Response
     */
    public function show(RoleModel $roleModel)
    {
      //  return $roleModel;
          $roleModelTrans=$roleModel->translate(request('lang'));
          if(!$roleModelTrans){
            return 'no data';
        }
        return new RoleModelDetailResource($roleModelTrans);
        //load('images','employee'));
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


        $data=$request->all();
        // $data['posted_date']=date('Y-m-d',strtotime($request->posted_date));
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
        foreach ($roleModel->images as $image) {

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

        if($image->path && file_exists($path.$image->path)){
        
             unlink($path.$image->path);
        }

        $image->delete();
        return response()->json('sucessfully deleted',200);


    }

    public function updateImage(Request $request,$role_model_id){
        $iu=new ImageUpload();
        $upload= $iu->multipleImageUpload($request->images,$role_model_id);
        if (count($upload) > 0) {
            return response()->json($upload,200);
        }else{
            return response()->json('error while uploading',401);

        }

    }

    public function updateAudio(Request $request, $id){
       
        $model=RoleModel::find($id);
        if($request->audio_path){


            $path= public_path().'/rolemodelaudios/';

            if($model->audio_path && file_exists($path.$model->audio_path)){
            
                 unlink($path.$model->audio_path);
            }
    

            $audio=$request->file('audio_path');
            $name = Str::random(5).time().'.'.$audio->extension();
            $audio->move(public_path().'/rolemodelaudios/', $name);
           
            //$image->refresh();
            //$img['id'] = $image->id;
            $model->audio_path = $name;
            $model->save();

        }
            return response()->json('success',200);

    }


    public function updateCardImage(Request $request, $id){
       
        $model=RoleModel::find($id);

        if($request->card_image){

            $path= public_path().'/rolemodelcardimages/';

            if($model->card_image && file_exists($path.$model->card_image)){
            
                 unlink($path.$model->card_image);
            }

            $file=$request->card_image;
            $name = Str::random(5).time().'.'.$file->extension();
            $file->move(public_path().'/rolemodelcardimages/', $name);
            $model->card_image = $name;
            $model->save();
        }

        $card_image = $model->card_image? asset('/rolemodelcardimages').'/'.$model->card_image: null;

            return response()->json($card_image,200);

    }


    
    public function verify($id){

        $rm=RoleModel::find($id);
        $rm->is_verified=1;
        $rm->save();
        return response()->json('verified',200);
    }


public function contentImageUpload(){

    try {

      //  return request()->upload;
       $file=request()->upload;
        return   $name = Str::random(5).time().'.'.$file->extension();
         //  $file->move(public_path().'/rolemodelimages/', $name);

         return response()->json(['url'=>asset('/rolemodelimages').'/'.$name],201);
        } catch (\Throwable $th) {

            return $th;
    }

  }

}
