<?php

namespace App\Http\Controllers\Require\Class;

use App\Http\Controllers\Require\Trait\MethodService;

class Service {

    public function __construct(
        private $service_name = '',
        private $personal_amount = '',
        private $number_of_days = '',
        private $hourlyintensity = ''
    ){}

    // Usamos el trait 'MethodService'. Para validar las propiedades: 
    use MethodService;
}