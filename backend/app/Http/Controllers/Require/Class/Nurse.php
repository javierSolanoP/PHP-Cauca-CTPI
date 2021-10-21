<?php

namespace App\Http\Controllers\Require\Class;

use App\Http\Controllers\Require\Trait\MethodNurse;

class Nurse {

    public function __construct(
        private $identification = '', 
        private $name = '', 
        private $last_name = '', 
        private $email = '', 
        private $password = '', 
        private $confirmPassword = ''
    ){}

    // Usamos el trait 'MethodNurse'. Para validar las propiedades: 
    use MethodNurse;
}