<?php

namespace App\Http\Controllers\Require\Trait;

use App\Http\Controllers\Require\Class\Validate;

trait MethodService {

    // Metodo para validar las propiedades de la instancia 'User': 
    public function validateData()
    {
        // Instnciamos la clase 'Validate', para validar las propiedades: 
        $validate = new Validate;

        // Declaramos el arreglo 'valid'. Para almacenar las propieadades validadas: 

        if(isset($_SESSION['validate'])){

            $data = $_SESSION['validate'];

            //Validamos la propiedad 'service_name': 
            if(!empty($data->service_name)){

                if($validate->validateString($data->service_name)){

                    // Almacenamos la propiedad en el arreglo: 
                    $valid['service_name'] = true;

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "service_name: no puede contener datos numericos."];
                }
            }

            //Validamos la propiedad 'personal_amount': 
            if(!empty($data->personal_amount)){

                if($validate->validateNumber($data->personal_amount)){

                    // Almacenamos la propiedad en el arreglo: 
                    $valid['personal_amount'] = true;

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "personal_amount: no puede contener datos alfanumericos."];
                }
            }

            //Validamos la propiedad 'number_of_days': 
            if(!empty($data->number_of_days)){

                if($validate->validateNumber($data->number_of_days)){

                   // Almacenamos la propiedad en el arreglo: 
                   $valid['number_of_days'] = true;

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "number_of_days: no puede contener datos alfanumericos."];
                }
            }

            //Validamos la propiedad 'hourlyintensity': 
            if(!empty($data->hourlyintensity)){

                if($validate->validateNumber($data->hourlyintensity)){

                   // Almacenamos la propiedad en el arreglo: 
                   $valid['hourlyintensity'] = true;

                }else{
                    // Retornamos el error:
                    return ["register" => false, "error" => "hourlyintensity: no puede contener datos alfanumericos."];
                }
            }

            // Retornamos la respuesta:
            return ['register' => true, 'fields' => $valid];
        }
    }
}