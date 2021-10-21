<?php

namespace App\Http\Controllers\shift_module;

use App\Http\Controllers\Controller;
use App\Models\Time;
use Exception;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    // Metodo para retornar todos los horarios de la tabla de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Time::select('start_time', 'finish_time');
        
        // Validamos que exista el registro en la tabla de la DB:
        $validateTime = $model->get();

        // Si existen, los retornamos: 
        if(count($validateTime) != 0){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'times' => $validateTime], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen horarios en el sistema.'], status: 404);
        }

    }

    // Metodo para registrar un horario en la tabla de la DB:  
    public function store(Request $request)
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($request->input('start_time'))
        && !empty($request->input('finish_time'))){

            // Realizamos la consulta a la tabla de la DB:
            $model = Time::where('start_time', $request->input('start_time'))
                            ->where('finish_time', $request->input('finish_time'));
            
            // Validamos que exista el registro en la tabla de la DB:
            $validateTime = $model->first();

            // Sino existe, lo registramos: 
            if(!$validateTime){

                try{

                    Time::create([
                        'start_time' => $request->input('start_time'),
                        'finish_time' => $request->input('finish_time')
                    ]);

                    // Retornamos la respuesta:
                    return response(content: ['register' => true], status: 201);

                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => 'Ya existe ese horario en el sistema'], status: 403);
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'start_time' o 'finish_time': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar un horario especifico: 
    public function show($start_time, $finish_time)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Time::select('id_time as id', 'start_time', 'finish_time')
                        ->where('start_time', $start_time)
                        ->where('finish_time', $finish_time);

        // Validamos que exista el registro en la tabla de la DB:
        $validateTime = $model->first();

        // Si existe, lo retornamos: 
        if($validateTime){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'time' => $validateTime], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese horario en el sistema.'], status: 404);
        }
    }

    // Metodo para eliminar un horario: 
    public function destroy($start_time, $finish_time)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Time::select('id_time as id', 'start_time', 'finish_time')
                        ->where('start_time', $start_time)
                        ->where('finish_time', $finish_time);

        // Validamos que exista el registro en la tabla de la DB:
        $validateTime = $model->first();

        // Si existe, lo eliminamos: 
        if($validateTime){

            try{

                // Eliminamos el horario: 
                $model->delete();

                // Retornamos la respuesta:
                return response(content: ['delete' => true], status: 204);

            }catch(Exception $e){
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
            }

        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' => 'No existe ese horario en el sistema.'], status: 404);
        }
    }
}
