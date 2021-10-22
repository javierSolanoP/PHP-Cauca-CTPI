<?php

namespace App\Http\Controllers\Require\Class; 

class Validate {

    public function __construct(){}

    // Metodo para validar un string: 
    public function validateString($data)
    {
        if(!preg_match("/[0-9]/", $data)){
            // Retornamos la respuesta: 
            return true;
        }else{
            // Retornamos el error: 
            return false;
        }
    }

    // Metodo para validar un numero: 
    public function validateNumber($data)
    {
        if(!preg_match("/[a-zA-Z]/", $data)){
            // Retornamos la respuesta: 
            return true;
        }else{
            // Retornamos el error: 
            return false;
        }
    }

    // Metodo para validar un email: 
    public function validateEmail($data)
    {
        if(filter_var($data, FILTER_VALIDATE_EMAIL)){
            // Retornamos la respuesta: 
            return true;
        }else{
            // Retornamos el error: 
            return false;
        }
    }

    // Metodo para validar una password: 
    public function validatePassword($hash, $password)
    {
        $validarPassword = password_verify(password: $password, hash: $hash);

        if($validarPassword){
            // Retornamos la respuesta: 
            return true;
        }else{
            // Retornamos el error: 
            return false;
        }
    }

}