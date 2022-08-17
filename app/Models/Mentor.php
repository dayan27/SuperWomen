<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mentor extends Authenticatable implements MustVerifyEmail
{
    use HasFactory,HasApiTokens,Notifiable;
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
        'bio',
        'field_id',
        'contact_id',
        'profile_picture',
        'intereset',
        'password',
        'location',
        'date_of_birth'
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
    public function users(){
        return $this->hasMany(User::class);
    }
    public function user_requests(){
        return $this->belongsToMany(User::class,'requests')->withPivot('id','state','request_message');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    public function contact(){
        return $this->belongsTo(Contact::class);
    }
    // public function fields(){
    //     return $this->belongsToMany(Field::class);
    // }

    public function messages(){
        return $this->belongsToMany(User::class,'messages')->withPivot(['message','user_id','mentor_id','seen','created_at']);
    }

    public function experiances(){
        return $this->hasMany(Experiance ::class);
    }

    public function availabilities(){
        return $this->hasMany(Availability::class);
    }
}

