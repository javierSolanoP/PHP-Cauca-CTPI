<?php

namespace App\Http\Controllers\patient_module;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\Class\Patient as ClassPatient;
use App\Models\Patient;
use Exception;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Metodo para retornar todos los pacientes de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Patient::select('patient_name', 'personal_amount', 'number_of_days', 'hourlyintensity')->get();

        // Validamos que existan registros en la tabla de la DB:
        if(count($model) != 0){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'patients' => $model], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen pacientes en el sistema.'], status: 404);
        }
    }

    // Metodo para registrar un nuevo paciente en la DB: 
    public function store(Request $request)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $patient_name = strtolower($request->input('patient_name'));

        // Validamos que los argumentos no esten vacios:
        if(!empty($patient_name)
        && !empty($request->input('personal_amount'))
        && !empty($request->input('number_of_days'))
        && !empty($request->input('hourlyintensity'))){

            // Realizamos la consulta a la tabla de la DB:
            $model = Patient::where('patient_name', $patient_name);

            // Validamos que exista el registro en la tabla de la DB:
            $validatePatient = $model->first();

            // Sino existe, validamos los argumentos recibidos: 
            if(!$validatePatient){

                // Intanciamos la clase 'Patient', para validar los argumentos: 
                $patient = new ClassPatient(patient_name: $patient_name,
                                            personal_amount: $request->input('personal_amount'),
                                            number_of_days: $request->input('number_of_days'),
                                            hourlyintensity: $request->input('hourlyintensity'));

                // Asignamos a la sesion 'validate' la instancia 'patient'. Con sus propiedades cargadas de informacion: 
                $_SESSION['validate'] = $patient;

                // Validamos los argumentos: 
                $validatePatientArgms = $patient->validateData();

                // Si los argumentos han sido validados, realizamos el registro: 
                if($validatePatientArgms['register']){

                    try{

                        Patient::create([
                            'patient_name' => $patient_name,
                            'personal_amount' => $request->input('personal_amount'),
                            'number_of_days' => $request->input('number_of_days'),
                            'hourlyintensity' => $request->input('hourlyintensity')
                        ]);

                        // Retornamos la respuesta:
                        return response(content: $validatePatientArgms, status: 201);

                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }
                }else{
                    // Retornamos el error:
                    return response(content: $validatePatientArgms, status: 403);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => 'Ya existe ese paciente en el sistema.'], status: 403);
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'patient_name' o 'personal_amount' o 'number_of_days' o hourlyintensity': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar un paciente especifico de la DB: 
    public function show($patient)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $patient_name = strtolower($patient);

        // Realizamos la consulta a la tabla de la DB:
        $model = Patient::select('id_patient as id', 'patient_name', 'personal_amount', 'number_of_days', 'hourlyintensity')->where('patient_name', $patient_name);

        // Validamos que exista el registro en la tabla de la DB:
        $validatePatient = $model->first();

        // Si existe, retornamos la informacion del paciente: 
        if($validatePatient){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'patient' => $validatePatient], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese paciente en el sistema.'], status: 404);
        }
        
    }

    // Metodo para actualizar un paciente especifico: 
    public function update(Request $request, $patient)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $patient_name = strtolower($patient);

        // Validamos que los argumentos no esten vacios:
        if(!empty($patient_name)
        && !empty($request->input('personal_amount'))
        && !empty($request->input('number_of_days'))
        && !empty($request->input('hourlyintensity'))){

            // Realizamos la consulta a la tabla de la DB:
            $model = Patient::where('patient_name', $patient_name);

            // Validamos que exista el registro en la tabla de la DB:
            $validatePatient = $model->first();

            // Si existe, validamos los argumentos recibidos: 
            if($validatePatient){

                // Intanciamos la clase 'Patient', para validar los argumentos: 
                $patient = new ClassPatient(patient_name: $patient_name,
                                            personal_amount: $request->input('personal_amount'),
                                            number_of_days: $request->input('number_of_days'),
                                            hourlyintensity: $request->input('hourlyintensity'));

                // Asignamos a la sesion 'validate' la instancia 'patient'. Con sus propiedades cargadas de informacion: 
                $_SESSION['validate'] = $patient;

                // Validamos los argumentos: 
                $validatePatientArgms = $patient->validateData();

                // Si los argumentos han sido validados, realizamos el registro: 
                if($validatePatientArgms['register']){

                    try{

                        $model->update([
                            'personal_amount' => $request->input('personal_amount'),
                            'number_of_days' => $request->input('number_of_days'),
                            'hourlyintensity' => $request->input('hourlyintensity')
                        ]);

                        // Retornamos la respuesta:
                        return response(content: $validatePatientArgms, status: 200);

                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }
                }else{
                    // Retornamos el error:
                    return response(content: $validatePatientArgms, status: 403);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => 'No existe ese paciente en el sistema.'], status: 404);
            }


        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'patient_name' o 'personal_amount' o 'number_of_days' o hourlyintensity': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para eliminar un paciente especifico: 
    public function destroy($patient)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $patient_name = strtolower($patient);

        // Realizamos la consulta a la tabla de la DB:
        $model = Patient::where('patient_name', $patient_name);
 
        // Validamos que exista el registro en la tabla de la DB:
        $validatePatient = $model->first();
 
        // Si existe, retornamos la informacion del paciente: 
        if($validatePatient){
 
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
            return response(content: ['delete' => false, 'error' => 'No existe ese paciente en el sistema.'], status: 404);
        }
    }
}

