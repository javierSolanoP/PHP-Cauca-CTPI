<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'speciality_name',
        'description'
    ]; 

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
