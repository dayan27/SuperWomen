<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Blog extends Model  implements TranslatableContract
{
    use HasFactory;
    use Translatable;    
    public $translatedAttributes = ['blog_title','blog_content','blog_intro'];

    public $fillable=[
        'blog_title',
        'blog_content',
        'blog_intro',
        'share',
        'like',
        'view',
        'posted_date',
        'time_take_to_read',
        'employee_id',
    ];


    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function fields(){
        return $this->belongsToMany(Field::class);
    }

    public function images(){
        return $this->hasMany(BlogImage::class);
    }

    public function comments(){
        return $this->hasMany(BlogComment::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
  

}

