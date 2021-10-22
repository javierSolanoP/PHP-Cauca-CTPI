<?php

namespace App\Http\Controllers\shift_module;

use App\Http\Controllers\admin_module\NurseController;
use App\Http\Controllers\Controller;
use App\Models\AssignmentTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentTimeController extends Controller
{
    // Metodo para retornar los harios de los turnos
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('assignment_times')

                    // Realizamos la consulta a la tabla del modelo 'Shift': 
                    ->join('shifts', 'shifts.id_shift', '=', 'assignment_times.shift_id')

                    // Realizamos la consulta a la tabla del modelo 'Time': 
                    ->join('times', 'times.id_time', '=', 'assignment_times.time_id')

                    // Seleccionamos los campos que se requieren: 
                    ->select('shifts.name_turn as shift', 'shifts.abbreviation_name as abbreviation', 'times.start_time', 'times.finish_time')

                    // Obtenemos los registros: 
                    ->get()

                    // Agrupamos por turnos: 
                    ->groupBy('shift');

        // Validamos que exista el registro en la tabla de la DB:
        if(count($model) != 0){

            // Declaramos el arreglo 'resgisters', para almacenar los grupos con indice numerico: 
            $registers = [];

            // Iteramos cada grupo, para almacenarlos en el arreglo 'registers': 
            foreach($model as $group){
                $registers[] = $group;
            }

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'shiftTimes' => $registers], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen horarios para ese turno'], status: 404);
        }
    }

    // Metodo para registrar un horario de un turno: 
    public function store(Request $request)
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($request->input('name_turn'))
        && !empty($request->input('time_id'))){

            // Instanciamos el controlador del modelo 'Shift'. Para validar que exista el turno: 
            $shiftController = new ShiftController; 

            // Validamos que exista: 
            $validateShift = $shiftController->show(name_turn: $request->input('name_turn'));

            // Extraemos el contenido de la respuesta: 
            $contentValidateShift = $validateShift->getOriginalContent();

            // Si existe, extraemos su 'id' y realizamos la consulta: 
            if($contentValidateShift['query']){

                // Extraemos su id: 
                $shift_id = $contentValidateShift['shift']['id']; 

                // Realizamos la consulta a la tabla de la DB:
                $model = AssignmentTime::where('name_turn')
                                        ->where('time_id');

                // Validamos que exista el registro en la tabla de la DB:
                $validateAssignmentTime = $model->first();

                // Sino existe, realizamos el registro: 
                if(!$validateAssignmentTime){

                    try{

                        AssignmentTime::create([
                            'time_id'  => $request->input('time_id'),
                            'shift_id' => $request->input('name_turn')
                        ]);

                        // Retornamos la respuesta:
                        return response(content: ['register' => true], status: 201);

                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'Ya existe ese horario asiganado a ese turno.'], status: 403);
                }
                

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidateShift['error']], status: $validateShift->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'name_turn' o 'time_id': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar los hoararios de un turno especifico: 
    public function show($name_turn, $time)
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($name_turn)
        && !empty($time)){

            // Instanciamos el controlador del modelo 'Shift'. Para validar que exista el turno: 
            $shiftController = new ShiftController; 

            // Validamos que exista: 
            $validateShift = $shiftController->show(name_turn: $name_turn);

            // Extraemos el contenido de la respuesta: 
            $contentValidateShift = $validateShift->getOriginalContent();

            // Si existe, extraemos su 'id' y realizamos la consulta: 
            if($contentValidateShift['query']){

                // Extraemos su id: 
                $shift_id = $contentValidateShift['shift']['id']; 

                // Realizamos la consulta a la tabla de la DB:
                $model = DB::table('assignment_times')

                            // Filtramos por el turno y el horario: 
                            ->where('shift_id', $shift_id)
                            ->where('time_id', $time)

                            // Realizamos la consulta a la tabla del modelo 'Shift': 
                            ->join('shifts', 'shifts.id_shift', '=', 'assignment_times.shift_id')

                            // Realizamos la consulta a la tabla del modelo 'Time': 
                            ->join('times', 'times.id_time', '=', 'assignment_times.time_id')

                            // Seleccionamos los campos que se requieren: 
                            ->select('shifts.name_turn as shift', 'shifts.abbreviation_name as abbreviation', 'times.start_time', 'times.finish_time')

                            // Obtenemos los registros: 
                            ->get();

                // Validamos que exista el registro en la tabla de la DB:
                if(count($model) != 0){

                    // Retornamos la respuesta:
                    return response(content: ['query' => true, 'shiftTime' => $model], status: 200);

                }else{
                    // Retornamos el error:
                    return response(content: ['query' => false, 'error' => 'No existen horarios para ese turno'], status: 404);
                }
                

            }else{
                // Retornamos el error:
                return response(content: $contentValidateShift, status: $validateShift->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => "Campo 'name_turn' o 'time_id': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para eliminar el horario de un turno especifico: 
    public function destroy($name_turn, $time)
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($name_turn)
        && !empty($time)){

            // Instanciamos el controlador del modelo 'Shift'. Para validar que exista el turno: 
            $shiftController = new ShiftController; 

            // Validamos que exista: 
            $validateShift = $shiftController->show(name_turn: $name_turn);

            // Extraemos el contenido de la respuesta: 
            $contentValidateShift = $validateShift->getOriginalContent();

            // Si existe, extraemos su 'id' y realizamos la consulta: 
            if($contentValidateShift['query']){

                // Extraemos su id: 
                $shift_id = $contentValidateShift['shift']['id']; 

                // Realizamos la consulta a la tabla de la DB:
                $model = AssignmentTime::where('time_id', $time)
                                        ->where('shift_id', $shift_id);

                // Validamos que exista el registro en la tabla de la DB:
                $validateAssignmentTime = $model->first();

                // Si existe, eliminamos el horario asignado a ese turno: 
                if($validateAssignmentTime){

                    try{

                        // Eliminamos el hoarario: 
                        $model->delete();

                        // Retornamos la respuesta:
                        return response(content: ['delete' => true], status: 204);

                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['delete' => false, 'error' => 'No existe ese horario para ese turno.'], status: 404);
                }

            }else{
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => $contentValidateShift['error']], status: $validateShift->status());
            }

        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' => "Campo 'name_turn' o 'time_id': NO deben estar vacios."], status: 403);
        }
    }
}
