<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class RoleModel extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;    
    public $translatedAttributes = ['title','content','intro'];

    public $fillable=[
        'title',
        'content',
        'intro',
        'employee_id',
        'video',
        'time_take_to_read',
    ];


    public function fields(){
        return $this->belongsToMany(Field::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function images(){
        return $this->hasMany(RoleModelImage::class);
    }

    public function comments(){
        return $this->hasMany(RoleModelComment::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}

