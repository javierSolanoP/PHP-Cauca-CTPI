<?php

namespace App\Http\Controllers\Require\Class;
use App\Http\Controllers\Require\Trait\MethodModule;

class Modules {

    public function __construct(
        private $module_name
    ){}

    use MethodModule;

}