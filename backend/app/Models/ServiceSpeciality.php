<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSpeciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'speciality_id'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
