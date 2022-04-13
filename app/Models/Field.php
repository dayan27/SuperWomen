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
    public function mentor(){
        return $this->hasOne(Mentor::class);
    }

    public function role_models(){
        return $this->belongsToMany(RoleModel::class);
    }

}
