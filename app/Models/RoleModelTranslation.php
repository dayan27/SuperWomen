<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModelTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['role_model_title','role_model_intro','role_model_content'];
    public $timestamps = false;
}
