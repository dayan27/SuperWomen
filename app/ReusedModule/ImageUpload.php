<?php
namespace App\ReusedModule;

use App\Models\BlogImage;
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
               $file->move(public_path().'/rolemodelimages/', $name);
               $image=new RoleModelImage();
               $image->image_path=$name;
               $image->role_model_id=$post_id;
               $image->save();
               $image->refresh();
               $img['id'] = $image->id;
               $img['path'] = asset('/rolemodelimages').'/'.$image->path;
               $images[]=$img;
        }

        return $images;
            } catch (\Throwable $th) {

                return $th;
        }

    // $product->images()->saveMany($images);


 }

 public function blogMultipleImageUpload($files,$blog_id){

    try {
        $images=[];

        foreach ($files as $file) {

            $name = Str::random(5).time().'.'.$file->extension();
            $file->move(public_path().'/blogimages/', $name);
           $image=new BlogImage();
           $image->path=$name;
           $image->blog_id=$blog_id;
           $image->save();
           $image->refresh();
           $img['id'] = $image->id;
           $img['path'] = asset('/blogimages').'/'.$image->path;
           $images[]=$img;
    }

    return $images;
        } catch (\Throwable $th) {

            // return $th;
    }

// $product->images()->saveMany($images);


}

public function contentImageUpload($file){

    try {
        $images=[];


           $name = Str::random(5).time().'.'.$file->extension();
           $file->move(public_path().'/rolemodelimages/', $name);
   

         return asset('/rolemodelimages').$name;
        } catch (\Throwable $th) {

            return $th;
    }

  }
}
