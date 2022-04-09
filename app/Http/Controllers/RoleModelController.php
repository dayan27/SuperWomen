<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\Tag;
use App\ReusedModule\ImageUpload;
use Illuminate\Http\Request;

class RoleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoleModel::with(['tags','fields'])
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

        ]);

        $data=$request->all();
        $data['employee_id']=$request->user()->id;
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
        $model->fields()->attach($request->fields);
        $model->tags()->attach($tag_ids);

                //calling image upload method from php class

        $iu=new ImageUpload();
        $upload= $iu->multipleImageUpload($request->images,$model->id);
        if (count($upload) > 0) {
        return response()->json($model->load('images'),201);
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
        //
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
        $roleModel->delete();
    }
}
