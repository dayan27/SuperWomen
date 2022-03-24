<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;
    public $fillable=[
        'title',
        'content',
        'like',
        'share',
        'view',
        'video',
        'posted_date',
        'time_take_to_read',
    ];
}
