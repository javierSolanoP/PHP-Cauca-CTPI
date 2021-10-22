<?php

namespace App\Http\Controllers\shift_module;

use App\Http\Controllers\admin_module\NurseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Model\Nurse;
use Illuminate\Support\Facades\DB;


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
            
            $shiftController = new ShiftController;
            $nurseController = new NurseController;


            $validateNameTurn = $shiftController->show(name_turn: $name_turn);
            $validateAbbrevationName = $shiftController->show(abbreviation_name: $abbrevation_name);
            $validateIdentification = $nurseController->show(identification: $identification);

            //extraemos el contenido de las respuesta
            $contentValidateNameTurn = $validateNameTurn->getOriginalContent();
            $contentValidateAbbrevationName  = $validateAbbrevationName->getOriginalContent();
            $contentValidateIdentification = $validateIdentification->getOriginalContent();

            //si existen, extraemos sus id
            if ($contentValidateNameTurn['query']) {
                if ($contentValidateAbbrevationName['query']) {
                    if ($contentValidateIdentification) {
                        
                        //extraemos los id
                        $nurseId = $contentValidateIdentification['role']->id;

                        


                    }
                }
            }



            





        }


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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
