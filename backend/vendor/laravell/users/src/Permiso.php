<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Trait\MethodPermission;

class Permiso {

    public function __construct(
        private $permission_name
    ){}

    // Usamos el trait 'MethodPermission'. Para validar las propiedades: 
    use MethodPermission;
}