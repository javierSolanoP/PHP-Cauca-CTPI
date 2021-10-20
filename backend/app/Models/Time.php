<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'finish_time'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
