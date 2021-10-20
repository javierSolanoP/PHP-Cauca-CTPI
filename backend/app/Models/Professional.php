<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'identification',
        'name',
        'last_name',
        'email',
        'password',
        'avatar',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'created_at', 
        'updated_at'
    ];
}
