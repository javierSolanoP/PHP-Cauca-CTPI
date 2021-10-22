<?php

namespace App\Http\Controllers\shift_module;

use App\Http\Controllers\admin_module\NurseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Nurse;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Exception;
use Nette\Schema\Context;

class ShiftController extends Controller
{
    //metodo para retornar todos los registros de laa tabla
    public function index()
    {
        //traemos los modulos y roles de la tabla 'turnos'
        $model = Shift::select('name_turn', 'abbreviation_name', 'schedule_id');

        // Validamos que existan registros en la tabla de la DB:
        $validateShift = $model->get();

        // Si existen, retornamos los registros: 
        if(count($validateShift) != 0){

           // Retornamos la respuesta:
           return response(content: ['query' => true, 'turnos' => $validateShift], status: 200);

        }else{
           // Retornamos el error:
           return response(content: ['query' => true, 'error' => 'No existen turnos en el sistema.'], status: 404);
        }
    }

    //meotodo para crear turnos
    public function store(Request $request){
        //converitmos los argumentos a minusculas
        $name_turn = strtolower($request->input('name_turn'));
        $abbrevation_name = strtolower($request->input('abbrevation_name'));
        $identification = $request->input('identification');

        //validamos que los argumento no esten vacios
        if (!empty($name_turn) && !empty($abbrevation_name) && !empty($identification)) {
            
         
            $nurseController = new NurseController;

            $validateIdentification = $nurseController->show(identification: $identification);

            //extraemos el contenido de las respuesta
            $contentValidateIdentification = $validateIdentification->getOriginalContent();

            //si existen, extraemos sus id    
            if ($contentValidateIdentification['query']) {
                
                //extraemos los id
                $idNurse = $contentValidateIdentification['nurse']->id;
                
                //realizamos la consulta a la tabla de la bd
                $model = Schedule::select('id_schedule')->where('nurse_id', $idNurse);
                $validateScheduleId = $model->first();

                // $model = Shift::select('schedule_id')->where('schedule_id', $validateScheduleId['id_schedule']);
                // $validateScheduleIdShift = $model->first();
                
                
                //si no existe realizamos el registro
                if (!$validateScheduleId) {                    
                    try {
                        //realizamos la insercción en las tablas
                        DB::transaction(function () use($idNurse, $name_turn, $abbrevation_name, $validateScheduleId) {

                            //insertamos un horario por defecto
                            $schedules = Schedule::create([
                                'monday' => '1',
                                'tuesday' => '1',
                                'wednesday' => '1',
                                'thursday' => '1',
                                'friday' => '1',
                                'saturday' => '1',
                                'sunday' => '0',
                                'nurse_id' => $idNurse
                            ]);

                            //realizamos nuevamente la consulta para obtener el id de la tabla 'schedule'
                            $model = Schedule::select('id_schedule')->where('nurse_id', $idNurse);
                            $validateScheduleId = $model->first();

                            //creamos el turno
                            $shifts = Shift::create([
                                'name_turn' => $name_turn,
                                'abbreviation_name' => $abbrevation_name,
                                'schedule_id' => $validateScheduleId->id_schedule
                            ]);


                        }); 

                        //retornamos la respuesta
                        return response(content: ['query' => true], status: 201);

                    } catch (Exception $e) {
                        

                        //retornamos el error
                        return response(content: ['query' => false, 'error' => $e->getMessage()],  status:500);
                    }

                }else{

                    //retornamos el registro
                    return response(content: ['register' => false, 'error' => 'ya existe este registro'], status: 403);
                }

            }
                

        }else{

            //retornamos el error
            return response(content: ['query' => false, 'error' => 'los campos no deben estar vacios']);
        }


    }

    public function show(){
        
    }

    //metodo para retornar los turnos y sus horarios
    // public function shifts()
    // {
    //     //realizamos la consulta a la base de datos
    //     $model = DB::table('shifts');

    //     //validamos que existan registros en la base de datos
    //     $validateShift = $model->get();

    //     //si existe, realizamos la consulta
    //     if ($validateShift) {
            
    //         //realizamos la consulta a la tabla de 'shifts'
    //         $register = $model->select('name_turn', 'monday')
    //                     ->join('schedules', 'schedules.id_schedules', '=', 'shifts.schedules_id')
    //                     ->get()
    //                     //agrupamos por turnos
    //                     ->groupBy('shifts');


    //         //si existen turnos, los retornamos
    //         if (count($register) != 0) {
                
    //             //declaramos el array turnos para almacenar los turnos
    //             $shifts = [];

    //             //itermaos el array 'shifts' para almacenar los turnos
    //             foreach ($shifts as $shift ) {
                    
    //                 //almacenamos los turnos en el arreglo 'shifts
    //                 $shifts[] = $shift;

    //             }

    //             //retornamos la respuesta
    //             return response(content: ['query' => true, 'turnos' => $shifts]);

    //         }else{

    //             //retornamos el error
    //             return response(content: ['query' => false, 'error' => 'No existen turnos asignados a horarios']);
    //         }

    //     }else{

    //         //retornamos el error
    //         return response(content: ['query' => false, 'error' => 'No existen turnos en el sistema']);
    //     }

    // }

    //metodo para eliminar un turno
    public function destroy($id)
    {
        //
    }
}
