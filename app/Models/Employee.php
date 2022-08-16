<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Employee extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'first_name',
        'last_name',
        'phone_no',
        'email',
        'password',
        'role',

    ];
    protected $hidden = [
        'password',

    ];

    public function mentor(){
        return $this->hasOne(mentor::class);
    }

    public function role_models(){
        return $this->hasMany(RoleModel::class);
    }

}
