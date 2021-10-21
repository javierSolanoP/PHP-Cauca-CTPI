<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'identification',
        'name',
        'last_name',
        'email',
        'password',
        'avatar',
        'session',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'created_at', 
        'updated_at'
    ];
}
