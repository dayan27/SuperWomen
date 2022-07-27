<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['blog_title','blog_intro','blog_content'];
    public $timestamps = false;
        
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
