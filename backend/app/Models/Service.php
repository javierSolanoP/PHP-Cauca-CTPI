<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'personal_amount',
        'number_of_days',
        'hourlyintensity'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
