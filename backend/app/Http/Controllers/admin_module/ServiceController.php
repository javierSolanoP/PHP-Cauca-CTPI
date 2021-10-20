<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\Class\Service as ClassService;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Metodo para retornar todos los servicios de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Service::select('id_service as id', 'service_name', 'personal_amount', 'number_of_days', 'hourlyintensity');

        // Validamos que exista el registro en la tabla de la DB:
        $validateService = $model->get();

        // Validamos que existan registros en la tabla de la DB:
        if(count($validateService) != 0){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'services' => $model], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen servicios en el sistema.'], status: 404);
        }
    }

    // Metodo para registrar un nuevo servicio en la DB: 
    public function store(Request $request)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name = strtolower($request->input('service_name'));

        // Validamos que los argumentos no esten vacios:
        if(!empty($service_name)
        && !empty($request->input('personal_amount'))
        && !empty($request->input('number_of_days'))
        && !empty($request->input('hourlyintensity'))){

            // Realizamos la consulta a la tabla de la DB:
            $model = Service::where('service_name', $request->input('service_name'));

            // Validamos que exista el registro en la tabla de la DB:
            $validateService = $model->first();

            // Sino existe, validamos los argumentos recibidos: 
            if(!$validateService){

                // Intanciamos la clase 'Service', para validar los argumentos: 
                $service = new ClassService(service_name: $service_name,
                                            personal_amount: $request->input('personal_amount'),
                                            number_of_days: $request->input('number_of_days'),
                                            hourlyintensity: $request->input('hourlyintensity'));

                // Asignamos a la sesion 'validate' la instancia 'service'. Con sus propiedades cargadas de informacion: 
                $_SESSION['validate'] = $service;

                // Validamos los argumentos: 
                $validateServiceArgms = $service->validateData();

                // Si los argumentos han sido validados, realizamos el registro: 
                if($validateServiceArgms['register']){

                    try{

                        Service::create([
                            'service_name' => $service_name,
                            'personal_amount' => $request->input('personal_amount'),
                            'number_of_days' => $request->input('number_of_days'),
                            'hourlyintensity' => $request->input('hourlyintensity')
                        ]);

                        // Retornamos la respuesta:
                        return response(content: $validateServiceArgms, status: 201);

                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }
                }else{
                    // Retornamos el error:
                    return response(content: $validateServiceArgms, status: 403);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => 'Ya existe ese servicio en el sistema.'], status: 403);
            }


        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'service_name' o 'personal_amount' o 'number_of_days' o hourlyintensity': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar un servicio especifico de la DB: 
    public function show($service)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name = strtolower($service);

        // Realizamos la consulta a la tabla de la DB:
        $model = Service::select('id_service as id', 'service_name', 'personal_amount', 'number_of_days', 'hourlyintensity')->where('service_name', $service_name);

        // Validamos que exista el registro en la tabla de la DB:
        $validateService = $model->first();

        // Si existe, retornamos la informacion del servicio: 
        if($validateService){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'service' => $validateService], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese servicio en el sistema.'], status: 404);
        }
        
    }

    // Metodo para actualizar un servicio especifico: 
    public function update(Request $request, $service)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name = strtolower($service);

        // Validamos que los argumentos no esten vacios:
        if(!empty($service_name)
        && !empty($request->input('personal_amount'))
        && !empty($request->input('number_of_days'))
        && !empty($request->input('hourlyintensity'))){

            // Realizamos la consulta a la tabla de la DB:
            $model = Service::where('service_name', $service_name);

            // Validamos que exista el registro en la tabla de la DB:
            $validateService = $model->first();

            // Si existe, validamos los argumentos recibidos: 
            if($validateService){

                // Intanciamos la clase 'Service', para validar los argumentos: 
                $service = new ClassService(service_name: $service_name,
                                            personal_amount: $request->input('personal_amount'),
                                            number_of_days: $request->input('number_of_days'),
                                            hourlyintensity: $request->input('hourlyintensity'));

                // Asignamos a la sesion 'validate' la instancia 'service'. Con sus propiedades cargadas de informacion: 
                $_SESSION['validate'] = $service;

                // Validamos los argumentos: 
                $validateServiceArgms = $service->validateData();

                // Si los argumentos han sido validados, realizamos el registro: 
                if($validateServiceArgms['register']){

                    try{

                        $model->update([
                            'personal_amount' => $request->input('personal_amount'),
                            'number_of_days' => $request->input('number_of_days'),
                            'hourlyintensity' => $request->input('hourlyintensity')
                        ]);

                        // Retornamos la respuesta:
                        return response(content: $validateServiceArgms, status: 200);

                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }
                }else{
                    // Retornamos el error:
                    return response(content: $validateServiceArgms, status: 403);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => 'No existe ese servicio en el sistema.'], status: 404);
            }


        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'service_name' o 'personal_amount' o 'number_of_days' o hourlyintensity': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para eliminar un servicio especifico: 
    public function destroy($service)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name = strtolower($service);

        // Realizamos la consulta a la tabla de la DB:
        $model = Service::where('service_name', $service_name);
 
        // Validamos que exista el registro en la tabla de la DB:
        $validateService = $model->first();
 
        // Si existe, retornamos la informacion del servicio: 
        if($validateService){
 
            try{

                // Eliminamos el registro: 
                $model->delete();

                // Retornamos la respuesta:
                return response(status: 204);

            }catch(Exception $e){
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
            }
 
        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' => 'No existe ese servicio en el sistema.'], status: 404);
        }
    }
}
