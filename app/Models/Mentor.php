<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_no',
        'email',
        'biography',
        'field_id',
        'contact_id',
        'city',
        'intereset',
        'password',
        'is_active',
        'biograph',
        'profile_picture',
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
        return $this->belongsToMany(User::class,'requests');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    public function contact(){
        return $this->belongsTo(Contact::class);
    }
    public function fields(){
        return $this->belongsToMany(Field::class);
    }
}
