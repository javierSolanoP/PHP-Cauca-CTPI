<?php

namespace App\Http\Controllers\Require\Trait;

use App\Http\Controllers\Require\Class\Validate;

session_start(); 

trait MethodNurse {

     // Metodo para validar las propiedades de la instancia 'nurse': 
     public function validateData()
     {
        // Instnciamos la clase 'Validate', para validar las propiedades: 
        $validate = new Validate;

        // Declaramos el arreglo 'valid'. Para almacenar las propieadades validadas: 
        $valid = [];
 
        if(isset($_SESSION['validate'])){
 
            $data = $_SESSION['validate'];
 
            //Validamos la propiedad 'identification': 
            if(!empty($data->identification)){
 
                if($validate->validateNumber($data->identification)){
 
                    // Almacenamos la propiedad validada al arreglo 'valid': 
                    $valid['identification'] = true;
 
                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "identification: no puede contener datos alfanumericos."];
                }
            }
             
            //Validamos la propiedad 'name': 
            if(!empty($data->name)){
                 
                if($validate->validateString($data->name)){
                     
                    // Almacenamos la propiedad validada al arreglo 'valid': 
                    $valid['name'] = true;
 
                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "name: no puede contener datos numericos."];
                }
            }
 
            //Validamos el campo 'last_name':
            if(!empty($data->last_name)){
                  
                if($validate->validateString($data->last_name)){
 
                    // Almacenamos la propiedad validada al arreglo 'valid': 
                    $valid['last_name'] = true;
 
                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "last_name: no puede contener datos numericos."];
                }
            }
 
            //Validamos el campo email:
            if(!empty($data->email)){
                  
                if($validate->validateEmail($data->email)){
 
                    // Almacenamos la propiedad validada al arreglo 'valid': 
                    $valid['email'] = true;
 
                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "email: no es un dato tipo email."];
                }
            }
 
            // Validamos que las propiedades de la 'password' coincidad: 
            if(!empty($data->password) && !empty($data->confirmPassword)){
 
                if($data->password == $data->confirmPassword){
 
                    // Almacenamos la propiedad validada al arreglo 'valid': 
                    $valid['password']  = true;
 
                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" =>"La passwords no coinciden."];
                }
            }
 
            //Retornamos la respuesta:      
            return ['register' => true, 'fields' => $valid];
 
        }
    }
}