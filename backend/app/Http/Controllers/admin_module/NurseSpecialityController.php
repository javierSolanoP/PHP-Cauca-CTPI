<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Models\NurseSpeciality;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NurseSpecialityController extends Controller
{
    // Metodo para retornar todas las especialidades de las enfermeras: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('nurse_specialities')

                    // Realizamos la consulta a la tabla del modelo 'Nurse': 
                    ->join('nurses', 'nurses.id_nurse', '=', 'nurse_specialities.nurse_id')

                    // Realizamos la consulta a la tabla del modelo 'Speciality': 
                    ->join('specialities', 'specialities.id_speciality', '=', 'nurse_specialities.speciality_id')

                    // Seleccionamos los campos que se requieren: 
                    ->select('specialities.speciality_name as speciality', 'specialities.description', 'nurses.identification as identification')

                    // Obtenemos todas las especialidades asociadas a las enfermeras: 
                    ->get()

                    // Agrupamos por identification: 
                    ->groupBy('identification');

        // Validamos que existan especialidades asociadas a las enfermeras: 
        if(count($model) != 0){

            // Declaramos el arreglo 'resgisters', para almacenar los grupos con indice numerico: 
            $registers = [];

            // Iteramos cada grupo, para almacenarlos en el arreglo 'registers': 
            foreach($model as $group){
                $registers[] = $group;
            }

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'nursesSpecialities' => $registers], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen especialidades para las enfermeras.'], status: 404);
        }

    }

    // Metodo para registrar una especialidad de una enfermera: 
    public function store(Request $request)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $identification = strtolower($request->input('identification'));
        $speciality   = strtolower($request->input('speciality'));

        // Validamos que los argumentos no esten vacios:
        if(!empty($identification)
        && !empty($speciality)){

            // Instanciamos los controladores de los modelos 'nurse' y 'Speciality'. Para validar que existan: 
            $nurseController = new NurseController;
            $specialityController   = new SpecialityController;

            // Validamos que existan: 
            $validateNurse = $nurseController->show(identification: $identification);
            $validateSpeciality   = $specialityController->show(speciality: $speciality);

            // Extraemos el contenido de las respuestas de validacion: 
            $contentValidateNurse  = $validateNurse->getOriginalContent();
            $contentValidateSpeciality    = $validateSpeciality->getOriginalContent();

            // Si existen, extraemos sus 'id': 
            if($contentValidateNurse['query']){

                if($contentValidateSpeciality['query']){

                    // Extraemos los id: 
                    $nurse_id = $contentValidateNurse['nurse']->id;
                    $speciality_id   = $contentValidateSpeciality['speciality']['id'];

                    // Realizamos la consulta a la tabla de la DB:
                    $model = NurseSpeciality::where('nurse_id', $nurse_id)->where('speciality_id', $speciality_id);

                    // Validamos que no exista el registro en la tabla de la DB:
                    $validateNurseSpeciality = $model->first();

                    // Sino existe, realizamos el registro: 
                    if(!$validateNurseSpeciality){

                        try{

                            NurseSpeciality::create([
                                'nurse_id' => $nurse_id,
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
                        return response(content: ['register' => false, 'error' => 'Ya existe esa especialidad a esa enfermera.'], status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $contentValidateSpeciality['error']], status: $validateSpeciality->status());
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidateNurse['error']], status: $validateNurse->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'identification' o 'speciality': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar las especialidades de una enfermera especifica: 
    public function show($identification)
    {
        // Instanciamos el controlador del modelo 'Nurse', para validar que exista: 
        $nurseController = new NurseController; 

        // Validamos que exista: 
        $validateNurse = $nurseController->show(identification: $identification);

        // Extraemos el contenido de la respuesta de validacion: 
        $contentValidateNurse = $validateNurse->getOriginalContent();

        // Si existe, extraemos su id y  realizamos la consulta a la DB: 
        if($contentValidateNurse['query']){

            // Extraemos el id: 
            $nurse_id = $contentValidateNurse['nurse']->id;

            // Realizamos la consulta a la tabla de la DB:
            $model = DB::table('nurse_specialities')

                        // Filtramos por el profesional: 
                        ->where('nurse_id', $nurse_id)

                        // Realizamos la consulta a la tabla del modelo 'Nurse': 
                        ->join('nurses', 'nurses.id_nurse', '=', 'nurse_specialities.nurse_id')

                        // Realizamos la consulta a la tabla del modelo 'Speciality': 
                        ->join('specialities', 'specialities.id_speciality', '=', 'nurse_specialities.speciality_id')

                        // Seleccionamos los campos que se requieren: 
                        ->select('specialities.speciality_name as speciality', 'specialities.description', 'nurses.identification as identification')

                        // Obtenemos todas las especialidades asociadas a esa enfermera: 
                        ->get();

            // Validamos que existan especialidades asociadas a la enfermera: 
            if(count($model) != 0){

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'nurseSpecialities' => $model], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen especialidades para esa enfermera.'], status: 404);
            }
        }else{
            // Retornamos el error:
            return response(content: $contentValidateNurse, status: $validateNurse->status());
        }
    }

    // Metodo para eliminar la especialidad de una enfermera: 
    public function destroy($identification, $speciality)
    {
        // Instanciamos el controlador del modelo 'Nurse', para validar que exista: 
        $nurseController        = new NurseController;
        $specialityController   = new SpecialityController; 

        // Validamos que exista: 
        $validateNurse = $nurseController->show(identification: $identification);
        $validateSpeciality   = $specialityController->show(speciality: $speciality);

        // Extraemos el contenido de la respuesta de validacion: 
        $contentValidateNurse = $validateNurse->getOriginalContent();
        $contentValidateSpeciality   = $validateSpeciality->getOriginalContent();

        // Si existe, extraemos sus id y  realizamos la consulta a la DB: 
        if($contentValidateNurse['query']){

            if($contentValidateSpeciality['query']){

                // Extraemos los id: 
                $nurse_id           = $contentValidateNurse['nurse']->id;
                $speciality_id      = $contentValidateSpeciality['speciality']['id']; 
    
                // Realizamos la consulta a la tabla de la DB:
                $model = NurseSpeciality::where('nurse_id', $nurse_id)->where('speciality_id', $speciality_id);
    
                // Validamos que exista esa especialidad asignada a la enfermera: 
                $validateNurseSpeciality = $model->first();
    
                // Validamos que existan especialidades asociadas a la enfermera: 
                if($validateNurseSpeciality){
    
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
                    return response(content: ['delete' => false, 'error' => 'No existe esa especialidad para esa enfermera.'], status: 404);
                }

            }else{
                // Retornamos el error:
                return response(content:['delete' => false, 'error' => $contentValidateSpeciality['error']], status: $validateSpeciality->status());
            }

        }else{
            // Retornamos el error:
            return response(content:['delete' => false, 'error' => $contentValidateNurse['error']], status: $validateNurse->status());
        }
    }
}
