<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Trait\MethodRole;

class Role {

    public function __construct(
        private $role_name 
    ){}

    // Usamos el trait 'MethodRole', para validar las propiedades: 
    use MethodRole;
}