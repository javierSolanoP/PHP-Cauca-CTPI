<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_turn',
        'abbreviation_name',
        'schedule_id'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
