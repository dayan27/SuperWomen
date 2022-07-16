<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'date_of_birth',
        'education_level_id',
        'is_active',
        'profile_picture',
        'mentor_id',
        'bio'
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mentor(){
        return $this->belongsTo(Mentor::class);
    }

    public function mentor_requests(){
        return $this->belongsToMany(Mentor::class,'requests');
    }


    public function education_level(){
        return $this->belongsTo(EducationLevel::class);
    }

    public function interests(){
        return $this->belongsToMany(Field::class);
    }

    public function messages(){
        return $this->belongsToMany(Mentor::class,'messages');
    }

}
