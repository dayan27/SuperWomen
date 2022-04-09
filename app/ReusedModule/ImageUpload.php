<?php
namespace App\ReusedModule;
use App\Models\Image;
use App\Models\NewsImage;
use App\Models\RoleModelImage;
use Illuminate\Support\Str;
Class ImageUpload{

    public function multipleImageUpload($files,$post_id){

        try {
            $images=[];

            foreach ($files as $file) {

               $name = Str::random(5).time().'.'.$file->extension();
               $file->move(public_path().'/images/', $name);
               $image=new RoleModelImage();
               $image->path=$name;
               $image->role_model_id=$post_id;
               $image->save();
               $image->refresh();
               $img['id'] = $image->id;
               $img['path'] = asset('/images').'/'.$image->path;
               $images[]=$img;
        }

        return $images;
            } catch (\Throwable $th) {

                return $th;
        }

    // $product->images()->saveMany($images);


 }

 public function newsMultipleImageUpload($files,$news_id){

    try {
        $images=[];

        foreach ($files as $file) {

            $name = Str::random(5).time().'.'.$file->extension();
            $file->move(public_path().'/images/', $name);
           $image=new NewsImage();
           $image->path=$name;
           $image->news_id=$news_id;
           $image->save();
           $image->refresh();
           $img['id'] = $image->id;
           $img['path'] = asset('/images').'/'.$image->path;
           $images[]=$img;
    }

    return $images;
        } catch (\Throwable $th) {

            // return $th;
    }

// $product->images()->saveMany($images);


}
}
