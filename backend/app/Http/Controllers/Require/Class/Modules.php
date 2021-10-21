<?php

namespace App\Http\Controllers\Require\Class;
use App\Http\Controllers\Require\Trait\MethodModule;

class Modules {

    public function __construct(
        private $module_name
    ){}

    // Usamos el trait 'MetodModule'. Para validar las propiedades:
    use MethodModule;

}