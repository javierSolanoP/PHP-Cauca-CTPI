<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalSpeciality as ModelsProfessionalSpeciality;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessionalSpecialityController extends Controller
{
    // Metodo para retornar todas las especialidades de los profesionales: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('professional_specialities')

                    // Realizamos la consulta a la tabla del modelo 'Professional': 
                    ->join('professionals', 'professionals.id_professional', '=', 'professional_specialities.professional_id')

                    // Realizamos la consulta a la tabla del modelo 'Speciality': 
                    ->join('specialities', 'specialities.id_speciality', '=', 'professional_specialities.speciality_id')

                    // Seleccionamos los campos que se requieren: 
                    ->select('specialities.speciality_name as speciality', 'specialities.description', 'professionals.identification as identification')

                    // Obtenemos todas las especialidades asociadas a ese profesional: 
                    ->get()

                    // Agrupamos por identification: 
                    ->groupBy('identification');

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
            return response(content: ['query' => false, 'error' => 'No existen especialidades para los profesionales.'], status: 404);
        }

    }

    // Metodo para registrar una especialidad de un profesional: 
    public function store(Request $request)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $identification = strtolower($request->input('identification'));
        $speciality   = strtolower($request->input('speciality'));

        // Validamos que los argumentos no esten vacios:
        if(!empty($identification)
        && !empty($speciality)){

            // Instanciamos los controladores de los modelos 'Professional' y 'Speciality'. Para validar que existan: 
            $professionalController = new ProfessionalController;
            $specialityController   = new SpecialityController;

            // Validamos que existan: 
            $validateProfessional = $professionalController->show(identification: $identification);
            $validateSpeciality   = $specialityController->show(speciality: $speciality);

            // Extraemos el contenido de las respuestas de validacion: 
            $contentValidateProfessional  = $validateProfessional->getOriginalContent();
            $contentValidateSpeciality    = $validateSpeciality->getOriginalContent();

            // Si existen, extraemos sus 'id': 
            if($contentValidateProfessional['query']){

                if($contentValidateSpeciality['query']){

                    // Extraemos los id: 
                    $professional_id = $contentValidateProfessional['professional']->id;
                    $speciality_id   = $contentValidateSpeciality['speciality']['id'];

                    // Realizamos la consulta a la tabla de la DB:
                    $model = ModelsProfessionalSpeciality::where('professional_id', $professional_id)->where('speciality_id', $speciality_id);

                    // Validamos que no exista el registro en la tabla de la DB:
                    $validateProfessionalSpeciality = $model->first();

                    // Sino existe, realizamos el registro: 
                    if(!$validateProfessionalSpeciality){

                        try{

                            ModelsProfessionalSpeciality::create([
                                'professional_id' => $professional_id,
                                'speciality_id' => $speciality_id
                            ]);

                            // Retornamos la respuesta:
                            return response(content: ['register' => true], status: 201);

                        }catch(Exception $e){
                            // Retornamos el error:
                            return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                        }

                    }else{
                        // Retornamos el error:
                        return response(content: ['register' >= false, 'error' => 'Ya existe esa especialidad a ese profesional.'], status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $contentValidateSpeciality['error']], status: $validateSpeciality->status());
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidateProfessional['error']], status: $validateProfessional->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'identification' o 'speciality': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar las especialidades de un profesional especifico: 
    public function show($identification)
    {
        // Instanciamos el controlador del modelo 'Service', para validar que exista: 
        $professionalController = new ProfessionalController; 

        // Validamos que exista: 
        $validateProfessional = $professionalController->show(identification: $identification);

        // Extraemos el contenido de la respuesta de validacion: 
        $contentValidateProfessional = $validateProfessional->getOriginalContent();

        // Si existe, extraemos su id y  realizamos la consulta a la DB: 
        if($contentValidateProfessional['query']){

            // Extraemos el id: 
            $professional_id = $contentValidateProfessional['professional']->id;

            // Realizamos la consulta a la tabla de la DB:
            $model = DB::table('professional_specialities')

                        // Filtramos por el profesional: 
                        ->where('professional_id', $professional_id)

                        // Realizamos la consulta a la tabla del modelo 'Professional': 
                        ->join('professionals', 'professionals.id_professional', '=', 'professional_specialities.professional_id')

                        // Realizamos la consulta a la tabla del modelo 'Speciality': 
                        ->join('specialities', 'specialities.id_speciality', '=', 'professional_specialities.speciality_id')

                        // Seleccionamos los campos que se requieren: 
                        ->select('specialities.speciality_name as speciality', 'specialities.description', 'professionals.identification as identification')

                        // Obtenemos todas las especialidades asociadas a ese profesional: 
                        ->get();

            // Validamos que existan especialidades asociadas al servicio: 
            if(count($model) != 0){

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'professional-specialities' => $model], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen especialidades para ese profesional.'], status: 404);
            }
        }else{
            // Retornamos el error:
            return response(content: $contentValidateProfessional, status: $validateProfessional->status());
        }
    }

    // Metodo para eliminar la especialidad de un profesional: 
    public function destroy($identification, $speciality)
    {
        // Instanciamos el controlador del modelo 'Service', para validar que exista: 
        $professionalController = new ProfessionalController;
        $specialityController   = new SpecialityController; 

        // Validamos que exista: 
        $validateProfessional = $professionalController->show(identification: $identification);
        $validateSpeciality   = $specialityController->show(speciality: $speciality);

        // Extraemos el contenido de la respuesta de validacion: 
        $contentValidateProfessional = $validateProfessional->getOriginalContent();
        $contentValidateSpeciality   = $validateSpeciality->getOriginalContent();

        // Si existe, extraemos sus id y  realizamos la consulta a la DB: 
        if($contentValidateProfessional['query']){

            if($contentValidateSpeciality['query']){

                // Extraemos los id: 
                $professional_id    = $contentValidateProfessional['professional']->id;
                $speciality_id      = $contentValidateSpeciality['speciality']['id']; 
    
                // Realizamos la consulta a la tabla de la DB:
                $model = ModelsProfessionalSpeciality::where('professional_id', $professional_id)->where('speciality_id', $speciality_id);
    
                // Validamos que exista esa especialidad asignada al servicio: 
                $validateProfessionalSpeciality = $model->first();
    
                // Validamos que existan especialidades asociadas al servicio: 
                if($validateProfessionalSpeciality){
    
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
                    return response(content: ['delete' => false, 'error' => 'No existe esa especialidad para ese profesional.'], status: 404);
                }

            }else{
                // Retornamos el error:
                return response(content:['delete' => false, 'error' => $contentValidateSpeciality['error']], status: $validateSpeciality->status());
            }

        }else{
            // Retornamos el error:
            return response(content:['delete' => false, 'error' => $contentValidateProfessional['error']], status: $validateProfessional->status());
        }
    }
}

