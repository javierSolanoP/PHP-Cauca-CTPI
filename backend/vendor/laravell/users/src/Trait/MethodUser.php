<?php

namespace App\Http\Controllers\Trait;

use App\Http\Controllers\Class\Validate;
use Exception;

session_start();

trait MethodUser {

    // Metodo para validar las propiedades de la instancia 'User': 
    public function validateData()
    {
        $validate = new Validate;
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

            //Validamos la propieadad 'telephone': 
            if(!empty($data->telephone)){
                
                if($validate->validateNumber($data->telephone)){

                    // Almacenamos la propiedad validada al arreglo 'valid': 
                    $valid['telephone'] = true;

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "telephone: no puede contener datos alfanumericos."];
                }
            }

            //Retornamos la respuesta:      
            try{
                return ['register' => true, 'fields' => $valid];
            }catch(Exception $e){
                return ['register' => false, 'error' => $e->getMessage()];
            }

        }
    }
}