<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Models\ServiceSpeciality;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class ServiceSpecialityController extends Controller
{
    // Metodo para retornar todos las especialidades de los servicios: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('service_specialities')

                    // Realizamos la consulta a la tabla del modelo 'Service': 
                    ->join('services', 'services.id_service', '=', 'service_specialities.service_id')

                    // Realizamos la consulta a la tabla del modelo 'Speciality': 
                    ->join('specialities', 'specialities.id_speciality', '=', 'service_specialities.speciality_id')

                    // Seleccionamos los campos que se requieren: 
                    ->select('specialities.speciality_name as speciality', 'specialities.description', 'services.service_name as service')

                    // Obtenemos todas las especialidades asociadas a ese servicio: 
                    ->get()

                    // Agrupamos por servicos: 
                    ->groupBy('service');

        // Validamos que existan especialidades asociadas al servicio: 
        if(count($model) != 0){

            // Declaramos el arreglo 'resgisters', para almacenar los grupos con indice numerico: 
            $registers = [];

            // Iteramos cada grupo, para almacenarlos en el arreglo 'registers': 
            foreach($model as $group){
                $registers[] = $group;
            }

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'services-specialities' => $registers], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen especialidades para los servicios.'], status: 404);
        }
    }

    // Metodo para registrar una especialidad a un servicio especifico: 
    public function store(Request $request)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name    = strtolower($request->input('service_name'));
        $speciality_name = strtolower($request->input('speciality_name'));

        // Validamos que los argumentos no esten vacios:
        if(!empty('service_name')
        && !empty('speciality_name')){

            // Instanciamos los controladores de los modelos 'Service' y 'Speciality'. Para validar que existan: 
            $serviceController    = new ServiceController;
            $specialityController = new SpecialityController;

            // Validamos que existan: 
            $validateService    = $serviceController->show(service: $service_name);
            $validateSpeciality = $specialityController->show(speciality: $speciality_name);

            // Extraemos el contenido de las respuestas de validacion: 
            $contentValidateService    = $validateService->getOriginalContent();
            $contentValidateSpeciality = $validateSpeciality->getOriginalContent();

            // Si existen, extraemos sus 'id': 
            if($contentValidateService['query']){

                if($contentValidateSpeciality['query']){

                    // Extraemos los id: 
                    $service_id     = $contentValidateService['service']['id'];
                    $speciality_id  = $contentValidateSpeciality['speciality']['id'];

                    // Realizamos la consulta a la tabla de la DB:
                    $model = ServiceSpeciality::where('service_id', $service_id)->where('speciality_id', $speciality_id);

                    // Validamos que no exista el registro en la tabla de la DB:
                    $validateServiceSpeciality = $model->first();

                    // Sino existe, lo registramos: 
                    if(!$validateServiceSpeciality){

                        try{

                            ServiceSpeciality::create([
                                'service_id'    => $service_id,
                                'speciality_id' => $speciality_id
                            ]);

                            // Retornamos la respuesta:
                            return response(content: ['register' => true], status: 201);

                        }catch(Exception $e){
                            // Retornamos el error:
                            return ['register' => false, 'error' => $e->getMessage()];
                        }

                    }else{
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => 'Ya existe esa especialidad para ese servicio.'], status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $contentValidateSpeciality['error']], status: $validateSpeciality->status());
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidateService['error']], status: $validateService->status());
            }


        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'service_name' o 'speciality_name': NO deben estar vacios."], status: 403);
        }

    }

    // Metodo para retornar las especialidades de un servicio especifico: 
    public function show($service)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name = strtolower($service);

        // Instanciamos el controlador del modelo 'Service', para validar que exista: 
        $serviceController = new ServiceController; 

        // Validamos que exista: 
        $validateService = $serviceController->show(service: $service_name);

        // Extraemos el contenido de la respuesta de validacion: 
        $contentValidateService = $validateService->getOriginalContent();

        // Si existe, extraemos su id y  realizamos la consulta a la DB: 
        if($contentValidateService['query']){

            // Extraemos el id: 
            $service_id = $contentValidateService['service']['id'];

            // Realizamos la consulta a la tabla de la DB:
            $model = DB::table('service_specialities')

                        // Filtramos por el servicio: 
                        ->where('service_id', $service_id)

                        // Realizamos la consulta a la tabla del modelo 'Speciality': 
                        ->join('specialities', 'specialities.id_speciality', '=', 'service_specialities.speciality_id')

                        // Seleccionamos los campos que se requieren: 
                        ->select('specialities.speciality_name', 'specialities.description')

                        // Obtenemos todas las especialidades asociadas a ese servicio: 
                        ->get();

            // Validamos que existan especialidades asociadas al servicio: 
            if(count($model) != 0){

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'specialities' => $model], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen especialidades para ese servicio.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: $contentValidateService, status: $validateService->status());
        }

    }

    // Metodo para eliminar una especialidad de un servicio especifico: 
    public function destroy($service, $speciality)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name    = strtolower($service);
        $speciality_name = strtolower($speciality);

        // Instanciamos los controladores de los modelos 'Service' y 'Speciality'. Para validar que existan: 
        $serviceController    = new ServiceController;
        $specialityController = new SpecialityController;

        // Validamos que existan: 
        $validateService    = $serviceController->show(service: $service_name);
        $validateSpeciality = $specialityController->show(speciality: $speciality_name);

        // Extraemos el contenido de las respuestas de validacion: 
        $contentValidateService    = $validateService->getOriginalContent();
        $contentValidateSpeciality = $validateSpeciality->getOriginalContent();

        // Si existe, extraemos sus id y  realizamos la consulta a la DB: 
        if($contentValidateService['query']){

            // Extraemos los id: 
            $service_id    = $contentValidateService['service']['id'];
            $speciality_id = $contentValidateSpeciality['speciality']['id']; 

            // Realizamos la consulta a la tabla de la DB:
            $model = ServiceSpeciality::where('service_id', $service_id)->where('speciality_id', $speciality_id);

            // Validamos que exista esa especialidad asignada al servicio: 
            $validateServiceSpeciality = $model->first();

            // Validamos que existan especialidades asociadas al servicio: 
            if($validateServiceSpeciality){

                try{

                    // Eliminamos la especialidad: 
                    $model->delete();

                    // Retornamos la respuesta:
                    return response(content: ['delete' => true], status: 204);

                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
                }
            }else{
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => 'No existe esa especialidad para ese servicio.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' => $contentValidateService['error']], status: $validateService->status());
        }
    }
}
