<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSpeciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'speciality_id'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
