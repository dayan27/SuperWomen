<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModelComment extends Model
{
    use HasFactory;
    public function role_model(){
        return $this->belongsTo(RoleModel::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }

}
