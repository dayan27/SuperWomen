<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentWriter extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_no',
        'email',
        'intereset',
        'password',
        'is_active',
    
        'profile_picture',
    ];
    protected $hidden = [
        'password',
        
    ];
}
