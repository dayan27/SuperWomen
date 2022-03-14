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
        'time_take_to_read',
    ];
    public function blogImages(){
        return $this->hasMany(BlogImage::class);
    }
    
}

