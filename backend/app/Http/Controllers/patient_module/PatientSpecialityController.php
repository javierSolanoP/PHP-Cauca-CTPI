<?php

namespace App\Http\Controllers\patient_module;

use App\Http\Controllers\admin_module\SpecialityController;
use App\Http\Controllers\Controller;
use App\Models\PatientSpeciality;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientSpecialityController extends Controller
{
    // Metodo para retornar todos las especialidades de los servicios: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('patient_specialities')

                    // Realizamos la consulta a la tabla del modelo 'Patient': 
                    ->join('patients', 'patients.id_patient', '=', 'patient_specialities.patient_id')

                    // Realizamos la consulta a la tabla del modelo 'Speciality': 
                    ->join('specialities', 'specialities.id_speciality', '=', 'patient_specialities.speciality_id')

                    // Seleccionamos los campos que se requieren: 
                    ->select('specialities.speciality_name as speciality', 'specialities.description', 'patients.patient_name as patient')

                    // Obtenemos todas las especialidades asociadas a ese servicio: 
                    ->get()

                    // Agrupamos por pacientes: 
                    ->groupBy('patient');

        // Validamos que existan especialidades asociadas al paciente: 
        if(count($model) != 0){

            // Declaramos el arreglo 'resgisters', para almacenar los grupos con indice numerico: 
            $registers = [];

            // Iteramos cada grupo, para almacenarlos en el arreglo 'registers': 
            foreach($model as $group){
                $registers[] = $group;
            }

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'patientsSpecialities' => $registers], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen especialidades para los pacientes.'], status: 404);
        }
    }

    // Metodo para registrar una especialidad a un paciente especifico: 
    public function store(Request $request)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $patient_name    = strtolower($request->input('patient_name'));
        $speciality_name = strtolower($request->input('speciality_name'));

        // Validamos que los argumentos no esten vacios:
        if(!empty('patient_name')
        && !empty('speciality_name')){

            // Instanciamos los controladores de los modelos 'Patient' y 'Speciality'. Para validar que existan: 
            $patientController    = new PatientController;
            $specialityController = new SpecialityController;

            // Validamos que existan: 
            $validatePatient    = $patientController->show(patient: $patient_name);
            $validateSpeciality = $specialityController->show(speciality: $speciality_name);

            // Extraemos el contenido de las respuestas de validacion: 
            $contentValidatePatient    = $validatePatient->getOriginalContent();
            $contentValidateSpeciality = $validateSpeciality->getOriginalContent();

            // Si existen, extraemos sus 'id': 
            if($contentValidatePatient['query']){

                if($contentValidateSpeciality['query']){

                    // Extraemos los id: 
                    $patient_id     = $contentValidatePatient['patient']['id'];
                    $speciality_id  = $contentValidateSpeciality['speciality']['id'];

                    // Realizamos la consulta a la tabla de la DB:
                    $model = PatientSpeciality::where('patient_id', $patient_id)->where('speciality_id', $speciality_id);

                    // Validamos que no exista el registro en la tabla de la DB:
                    $validatePatientSpeciality = $model->first();

                    // Sino existe, lo registramos: 
                    if(!$validatePatientSpeciality){

                        try{

                            PatientSpeciality::create([
                                'patient_id'    => $patient_id,
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
                        return response(content: ['register' => false, 'error' => 'Ya existe esa especialidad para ese paciente.'], status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $contentValidateSpeciality['error']], status: $validateSpeciality->status());
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidatePatient['error']], status: $validatePatient->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'patient_name' o 'speciality_name': NO deben estar vacios."], status: 403);
        }

    }

    // Metodo para retornar las especialidades de un paciente especifico: 
    public function show($patient)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $patient_name = strtolower($patient);

        // Instanciamos el controlador del modelo 'Patient', para validar que exista: 
        $patientController = new PatientController; 

        // Validamos que exista: 
        $validatePatient = $patientController->show(patient: $patient_name);

        // Extraemos el contenido de la respuesta de validacion: 
        $contentValidatePatient = $validatePatient->getOriginalContent();

        // Si existe, extraemos su id y  realizamos la consulta a la DB: 
        if($contentValidatePatient['query']){

            // Extraemos el id: 
            $patient_id = $contentValidatePatient['patient']['id'];

            // Realizamos la consulta a la tabla de la DB:
            $model = DB::table('patient_specialities')

                        // Filtramos por el paciente: 
                        ->where('patient_id', $patient_id)

                        // Realizamos la consulta a la tabla del modelo 'Speciality': 
                        ->join('specialities', 'specialities.id_speciality', '=', 'patient_specialities.speciality_id')

                        // Seleccionamos los campos que se requieren: 
                        ->select('specialities.speciality_name', 'specialities.description')

                        // Obtenemos todas las especialidades asociadas a ese paciente: 
                        ->get();

            // Validamos que existan especialidades asociadas al paciente: 
            if(count($model) != 0){

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'specialities' => $model], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen especialidades para ese paciente.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: $contentValidatePatient, status: $validatePatient->status());
        }

    }

    // Metodo para eliminar una especialidad de un paciente especifico: 
    public function destroy($patient, $speciality)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $patient_name    = strtolower($patient);
        $speciality_name = strtolower($speciality);

        // Instanciamos los controladores de los modelos 'patient' y 'Speciality'. Para validar que existan: 
        $patientController    = new PatientController;
        $specialityController = new SpecialityController;

        // Validamos que existan: 
        $validatePatient    = $patientController->show(patient: $patient_name);
        $validateSpeciality = $specialityController->show(speciality: $speciality_name);

        // Extraemos el contenido de las respuestas de validacion: 
        $contentValidatePatient    = $validatePatient->getOriginalContent();
        $contentValidateSpeciality = $validateSpeciality->getOriginalContent();

        // Si existe, extraemos sus id y  realizamos la consulta a la DB: 
        if($contentValidatePatient['query']){

            // Extraemos los id: 
            $patient_id    = $contentValidatePatient['patient']['id'];
            $speciality_id = $contentValidateSpeciality['speciality']['id']; 

            // Realizamos la consulta a la tabla de la DB:
            $model = PatientSpeciality::where('patient_id', $patient_id)->where('speciality_id', $speciality_id);

            // Validamos que exista esa especialidad asignada al paciente: 
            $validatePatientSpeciality = $model->first();

            // Validamos que existan especialidades asociadas al paciente: 
            if($validatePatientSpeciality){

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
            return response(content: ['delete' => false, 'error' => $contentValidatePatient['error']], status: $validatePatient->status());
        }
    }
}

