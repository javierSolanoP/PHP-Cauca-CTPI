<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Exception;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    // Metodo para retornar todas las espcialidades de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Speciality::select('speciality_name', 'description')->get();

        // Validamos que existan registros en la tabla de la DB:
        if(count($model) != 0){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'specialities' => $model], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen especialidades en el sistema.'], status: 404);
        }
    }

    // Metodo para registrar una nueva especialidad en la DB: 
    public function store(Request $request)
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($request->input('speciality_name'))
        && !empty($request->input('description'))){

            // Realizamos la consulta a la tabla de la DB:
            $model = Speciality::where('speciality_name', $request->input('speciality_name'));

            // Validamos que no exista el registro en la tabla de la DB:
            $validateSpeciality = $model->first();

            // Sino existe, realizamos el registro: 
            if(!$validateSpeciality){

                try{

                    Speciality::create([
                        'speciality_name' => $request->input('speciality_name'),
                        'description' => $request->input('description')
                    ]);

                    // Retornamos la respuesta:
                    return response(content: ['register' => true], status: 201);

                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => 'Ya existe esa especialidad en el sistema.'], status: 403);
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false , 'error' =>"Campo 'speciality_name' o 'description': NO debe estar vacio."], status: 403);
        }
    }

    // Metodo para retornar una especialidad especifica: 
    public function show($speciality)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Speciality::select('id_speciality as id', 'speciality_name', 'description')->where('speciality_name', $speciality);

        // Validamos que exista el registro en la tabla de la DB:
        $validateSpeciality = $model->first();

        // Si existe, retornamos la informacion de la especialidad: 
        if($validateSpeciality){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'speciality' => $validateSpeciality], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' =>'No existe esa especialidad en el sistema.'], status: 404);
        }
    }

    // Metodo para actualizar una especialidad especifica: 
    public function update(Request $request, $speciality)
    {
        // Validamos que los argumentos no esten vacios:
        if(!empty($speciality)
        && !empty($request->input('description'))){
 
            // Realizamos la consulta a la tabla de la DB:
            $model = Speciality::where('speciality_name', $speciality);
 
            // Validamos que no exista el registro en la tabla de la DB:
            $validateSpeciality = $model->first();
 
            // Si existe, realizamos el registro: 
            if($validateSpeciality){
 
                try{
 
                    $model->update([
                        'description' => $request->input('description')
                    ]);
 
                    // Retornamos la respuesta:
                    return response(content: ['register' => true], status: 201);
 
                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                }
 
            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => 'No existe esa especialidad en el sistema.'], status: 404);
            }
 
        }else{
            // Retornamos el error:
            return response(content: ['register' => false , 'error' =>"Campo 'speciality_name' o 'description': NO debe estar vacio."], status: 403);
        }
    }

    // Metodo parar eliminar una especialidad especifica: 
    public function destroy($speciality)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Speciality::select('id_speciality as id', 'speciality_name', 'description')->where('speciality_name', $speciality);

        // Validamos que exista el registro en la tabla de la DB:
        $validateSpeciality = $model->first();

        // Si existe, eliminamos la especialidad: 
        if($validateSpeciality){

            try{

                // Eliminamos la especialidad: 
                $model->delete();

                // Retornamos la respuesta:
                return response(status: 204);

            }catch(Exception $e){
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
            }

        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' =>'No existe esa especialidad en el sistema.'], status: 404);
        }
    }
}
