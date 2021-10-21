<?php

namespace App\Http\Controllers\Trait;

use App\Http\Controllers\Class\Validate;

trait MethodPermission {

    // Metodo para validar las propiedades de la instancia 'Permission': 
    public function validateData()
    {
        $validate = new Validate;

        if(isset($_SESSION['validate'])){

            $data = $_SESSION['validate'];

            //Validamos la propiedad 'permission_name': 
            if(!empty($data->permission_name)){

                if($validate->validateString($data->permission_name)){

                    // Retornamos la respuesta:
                    return ['register' => true];

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "permission_name: no puede contener datos alfanumericos."];
                }
            }
        }
    }
}