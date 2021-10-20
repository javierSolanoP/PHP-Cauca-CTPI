<?php

namespace App\Http\Controllers\Require\Trait;

use App\Http\Controllers\Require\Class\Validate;

trait MethodModule {

    // Metodo para validar las propiedades: 
    public function validateData()
    {
        // Instnciamos la clase 'Validate', para validar las propiedades: 
        $validate = new Validate;

        // Declaramos el arreglo 'valid'. Para almacenar las propieadades validadas: 

        if(isset($_SESSION['validate'])){

            $data = $_SESSION['validate'];

            //Validamos la propiedad 'module_name': 
            if(!empty($data->module_name)){

                if($validate->validateString($data->module_name)){

                    // Almacenamos la propiedad en el arreglo: 
                    $valid['module_name'] = true;

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "module_name: no puede contener datos numericos."];
                }
            }
            
            // Retornamos la respuesta:
            return ['register' => true, 'fields' => $valid];
        }
    }
}