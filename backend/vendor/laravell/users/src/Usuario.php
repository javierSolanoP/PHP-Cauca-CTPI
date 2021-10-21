<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Trait\MethodUser;

class Usuario {

    public function __construct(private $identification = '', 
                                private $name = '', 
                                private $last_name = '', 
                                private $email = '', 
                                private $password = '', 
                                private $confirmPassword = '',
                                private $telephone = ''
                                ){}

    // Se utiliza el trait 'MethodUser', para validar las propiedades: 
    use MethodUser;
}