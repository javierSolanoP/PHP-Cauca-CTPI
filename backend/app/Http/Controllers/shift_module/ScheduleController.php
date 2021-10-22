<?php

namespace App\Http\Controllers\shift_module;

use App\Http\Controllers\admin_module\NurseController;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    // Metodo para retornar todos los cronogramas de la tabla de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $schedules = DB::table('schedules')

                    // Realizamos la consulta a la tabla del modelo 'Nurse':
                    ->join('nurses', 'nurses.id_nurse', '=', 'schedules.nurse_id')

                    // Seleccionamos los campos qure se requiren: 
                    ->select('schedules.id_schedule as id', 'schedules.monday', 'schedules.tuesday', 'schedules.thursday', 'schedules.friday', 'schedules.saturday', 'schedules.sunday', 'nurses.identification')

                    // Obtenemos los registros: 
                    ->get()

                    // Agrupamos por enfermeras: 
                    ->groupBy('identification');

        // Validamos que exista el registro en la tabla de la DB:
        if(count($schedules) != 0){

            // Declaramos el arreglo 'resgisters', para almacenar los grupos con indice numerico: 
            $registers = [];

            // Iteramos cada grupo, para almacenarlos en el arreglo 'registers': 
            foreach($schedules as $schedule){
                $registers[] = $schedule;
            }

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'schedules' => $registers], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen cronogramas para las enfermera.'], status: 404);
        }
    }

    // Metodo para registrar un cronograma en la tabla de la DB:
    public function store(
        $identification_nurse,
        $monday = '',
        $tuesday = '',
        $wednesday = '',
        $thursday = '',
        $friday = '',
        $saturday = '',
        $sunday = ''
    )
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($identification_nurse)){

            // Instanciamos el controlador del modelo 'Nurse'. Para validar que exista la enfermera: 
            $nurseController = new NurseController;

            // Validamos que exista: 
            $validateNurse = $nurseController->show(identification: $identification_nurse);

            // Extraemos el contenido de la respuesta: 
            $contentValidateNurse = $validateNurse->getOriginalContent();

            // Si existe, extraemos su 'id' y registramos el cronograma: 
            if($contentValidateNurse['query']){

                // Extraemos su id: 
                $nurse_id = $contentValidateNurse['nurse']->id;

                // Realizamos la consulta a la tabla de la DB:
                $model = Schedule::where('nurse_id', $nurse_id);

                // Validamos que exista el registro en la tabla de la DB:
                $validateSchedule = $model->first();

                // Sino existe, lo registramos: 
                if(!$validateSchedule){

                    try{

                        Schedule::create([
                            'monday'    => $monday,
                            'tuesday'   => $tuesday,
                            'wednesday' => $wednesday,
                            'thursday'  => $thursday,
                            'friday'    => $friday,
                            'saturday'  => $saturday, 
                            'sunday'    => $sunday,
                            'nurse_id'  => $nurse_id
                        ]);
    
                        // Retornamos la respuesta:
                        return response(content: ['register' => true], status: 201);
    
                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }
                
                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'Ya existe ese cronograma en el sistema.'], status: 403);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidateNurse['error']], status: $validateNurse->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'identification_nurse': NO debe estar vacio."], status: 403);
        }
    }

    // Meotodo para retornar un cronograma especifico: 
    public function show($identification_nurse)
    {
        // Instanciamos el controlador del modelo 'Nurse'. Para validar que exista la enfermera: 
        $nurseController = new NurseController;

        // Validamos que exista: 
        $validateNurse = $nurseController->show(identification: $identification_nurse);
 
        // Extraemos el contenido de la respuesta: 
        $contentValidateNurse = $validateNurse->getOriginalContent();
 
        // Si existe, extraemos su 'id' y registramos el cronograma: 
        if($contentValidateNurse['query']){
 
            // Extraemos su id: 
            $nurse_id = $contentValidateNurse['nurse']->id;

            // Realizamos la consulta a la tabla de la DB:
            $model = Schedule::where('nurse_id', $nurse_id);

            // Validamos que exista el registro en la tabla de la DB:
            $validateSchedule = $model->first();

            // Si existe, lo retornamos: 
            if($validateSchedule){

                // Realizamos la consulta a la tabla de la DB:
                $schedules = DB::table('schedules')

                            // Filtramos por enfermera: 
                            ->where('nurse_id', $nurse_id)

                            // Realizamos la consulta a la tabla del modelo 'Nurse':

                            ->join('nurses', 'nurses.id_nurse', '=', 'schedules.nurse_id')

                            // Seleccionamos los campos qure se requiren: 
                            ->select('schedules.id_schedule as id', 'schedules.monday', 'schedules.tuesday', 'schedules.thursday', 'schedules.friday', 'schedules.saturday', 'schedules.sunday', 'nurses.id_nurse as id', 'nurses.identification')

                            // Obtenemos los registros: 
                            ->get();

                // Validamos que exista el registro en la tabla de la DB:
                if(count($schedules) != 0){

                    // Declaramos el arreglo 'resgisters', para almacenar los cronogramas con indice numerico: 
                    $registers = [];

                    // Iteramos cada grupo, para almacenarlos en el arreglo 'registers': 
                    foreach($schedules as $schedule){
                        $registers[] = $schedule;
                    }

                    // Retornamos la respuesta:
                    return response(content: ['query' => true, 'schedule' => $registers], status: 200);

                }else{
                    // Retornamos el error:
                    return response(content: ['query' => false, 'error' => 'No existen cronogramas para esa enfermera.'], status: 404);
                }

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existe ese cronograma en el sistema.'], status: 404);
            }

             
        }else{
            // Retornamos el error:
            return response(content: $contentValidateNurse, status: $validateNurse->status());
        }
    }

    // Metodo para actualizar un cronograma especifico: 
    public function update(
        $identification_nurse,
        $monday = '',
        $tuesday = '',
        $wednesday = '',
        $thursday = '',
        $friday = '',
        $saturday = '',
        $sunday = ''
    )
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($identification_nurse)){

            // Instanciamos el controlador del modelo 'Nurse'. Para validar que exista la enfermera: 
            $nurseController = new NurseController;

            // Validamos que exista: 
            $validateNurse = $nurseController->show(identification: $identification_nurse);

            // Extraemos el contenido de la respuesta: 
            $contentValidateNurse = $validateNurse->getOriginalContent();

            // Si existe, extraemos su 'id' y actualizamos el cronograma: 
            if($contentValidateNurse['query']){

                // Extraemos su id: 
                $nurse_id = $contentValidateNurse['nurse']->id;

                // Realizamos la consulta a la tabla de la DB:
                $model = Schedule::where('nurse_id', $nurse_id);

                // Validamos que exista el registro en la tabla de la DB:
                $validateSchedule = $model->first();

                // Si existe, lo actualizamos: 
                if($validateSchedule){

                    try{

                        $model->update([
                            'monday'    => $monday,
                            'tuesday'   => $tuesday,
                            'wednesday' => $wednesday,
                            'thursday'  => $thursday,
                            'friday'    => $friday,
                            'saturday'  => $saturday, 
                            'sunday'    => $sunday
                        ]);
    
                        // Retornamos la respuesta:
                        return response(content: ['register' => true], status: 201);
    
                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }
                
                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'No existe ese cronograma en el sistema.'], status: 404);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidateNurse['error']], status: $validateNurse->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'identification_nurse': NO deben estar vacios."], status: 403);
        }

    }

    // Metodo para eliminar un cronograma espcifico: 
    public function destroy($identification_nurse)
    {
        // Instanciamos el controlador del modelo 'Nurse'. Para validar que exista la enfermera: 
        $nurseController = new NurseController;

        // Validamos que exista: 
        $validateNurse = $nurseController->show(identification: $identification_nurse);
 
        // Extraemos el contenido de la respuesta: 
        $contentValidateNurse = $validateNurse->getOriginalContent();
 
        // Si existe, extraemos su 'id' y eliminamos el cronograma: 
        if($contentValidateNurse['query']){
 
            // Extraemos su id: 
            $nurse_id = $contentValidateNurse['nurse']->id;

            // Realizamos la consulta a la tabla de la DB:
            $model = Schedule::where('nurse_id', $nurse_id);

            // Validamos que exista el registro en la tabla de la DB:
            $validateSchedule = $model->first();

            // Si existe, lo eliminamos: 
            if($validateSchedule){

                try{

                    // Eliminamos el cronograma: 
                    $model->delete();

                    // Retornamos la respuesta:
                    return response(content: ['delete' => true], status: 204);

                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
                }

            }else{
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => 'No existe ese cronograma en el sistema.'], status: 404);
            }
             
        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' => $contentValidateNurse['error']], status: $validateNurse->status());
        }
    }
}
