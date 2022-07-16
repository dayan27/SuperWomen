<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModelTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['title','intro','content'];
    public $timestamps = false;

     
    public function role_model()
    {
        return $this->belongsTo(RoleModel::class);
    }
}
