<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'module_id'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
