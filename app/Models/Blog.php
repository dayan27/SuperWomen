<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public $fillable=[
        'title',
        'content',
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

