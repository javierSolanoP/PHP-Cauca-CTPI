<?php

namespace App\Http\Controllers\Trait;

use App\Http\Controllers\Class\Validate;

trait MethodRole {

    // Metodo para validar las propiedades de la instancia 'User': 
    public function validateData()
    {
        $validate = new Validate;

        if(isset($_SESSION['validate'])){

            $data = $_SESSION['validate'];

            //Validamos la propiedad 'role_name': 
            if(!empty($data->role_name)){

                if($validate->validateString($data->role_name)){

                    // Retornamos la respuesta:
                    return ['register' => true];

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "role_name: no puede contener datos alfanumericos."];
                }
            }
        }
    }
}