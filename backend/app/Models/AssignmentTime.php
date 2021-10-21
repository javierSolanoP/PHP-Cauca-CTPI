<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_id',
        'shift_id'
    ]; 

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
