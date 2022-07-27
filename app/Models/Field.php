<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    public $fillable=[
        'title',
    ];

    public function mentors(){
        return $this->belongsToMany(Mentor::class);
    }
    public function role_models(){
        return $this->belongsToMany(RoleModel::class);
    }

    public function blogs(){
        // return $this->belongsToMany(Blog::class);
        return $this->belongsToMany(Blog::class,'field_blog');

    }
}
