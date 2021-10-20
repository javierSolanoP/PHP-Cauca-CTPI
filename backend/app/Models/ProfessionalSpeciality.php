<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalSpeciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'speciality_id'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
