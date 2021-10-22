<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // Metodo para retornar todos los registros de la tabla de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Role::select('role_name as role');

        // Validamos que existan registros en la tabla de la DB:
        $validateRole = $model->get();

        // Si existen, retornamos los registros: 
        if(count($validateRole) != 0){

           // Retornamos la respuesta:
           return response(content: ['query' => true, 'roles' => $validateRole], status: 200);

        }else{
           // Retornamos el error:
           return response(content: ['query' => true, 'error' => 'No existen roles en el sistema.'], status: 404);
        }
    }

    // Metodo para retornar todos los roles con sus respectivos profesionales de la tabla de la DB: 
    public function roles()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('roles');

        // Validamos que exista el role:
        $validateRole = $model->get();

        // Si existe, realizamos la consulta a la tablas de los modelos 'Professional' y 'Permission':
        if($validateRole){

            // Realizamos la consulta a la tabla del modelo 'User': 
            $registers = $model ->join('professionals', 'roles.id_role', '=', 'professionals.role_id')

                                // Seleccionamos los campos que se requieren: 
                                ->select('roles.role_name as role', 'professionals.identification', 'professionals.name', 'professionals.last_name', 'professionals.email')

                                // Obtenemos los professional que pertenzcan al role: 
                                ->get()

                                // Agrupamos por roles: 
                                ->groupBy('role');

            // Si existen professionals asignados a ese role, los retornamos: 
            if(count($registers) != 0){

                // Declaramos el array 'professionals', para almacenar los professionales con indice numerico: 
                $professionals = [];

                // Iteramos los professionals almacenados en el array 'registers': 
                foreach($registers as $user){

                    // Almacenamos el professionals en el array 'users': 
                    $professionals[] = $user;

                }

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'roles' => $professionals], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen professionales con ese role.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen roles en el sistema.'], status: 404);
        }
    }

   // Metodo para registrar un role en la tabla de la DB: 
   public function store(Request $request)
   {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $role_name = strtolower($request->input(key: 'role_name'));

        // Validamos que los argumentos no esten vacios:
        if(!empty($role_name)){

           // Realizamos la consulta a la tabla de la DB:
           $model = Role::where('role_name', $role_name);

           // Validamos que exista el registro en la tabla de la DB:
           $validateRole = $model->first();

           // Sino existe, realizamos el registro: 
           if(!$validateRole){
                try{

                    // Realizamos el registro: 
                    Role::create(['role_name' => $role_name]);
                       
                    // Retornamos la respuesta:
                    return response(content: ['register' => true], status: 201);

                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                }

            }else{
               // Retornamos el error:
               return response(content: ['register' => false, 'error' => 'Ya existe ese role en el sistema.'], status: 403);
            }

        }else{
           // Retornamos el error:
           return response(content: ['registrer' => false, 'error' => "Campo 'role_name': NO debe estar vacio."], status: 403);
        }
   }

    // Metodo para retornar un role especifico: 
    public function show($role)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $role_name = strtolower($role);

        // Realizamos la consulta a la tabla de la DB:
        $model = Role::select('id_role as id', 'role_name as role')->where('role_name', $role_name);

        // Validamos que exista el registro en la tabla de la DB:
        $validateRole = $model->first();

        // Si existe, retornamos el role: 
        if($validateRole){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'role' => $validateRole], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese role en el sistema.'], status: 404);
        }
    }

    // Metodo para retornar las enfermeras asignadas con un role especifico: 
    public function nurses($role)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $role_name = strtolower($role);

        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('roles')->where('role_name', $role_name);

        // Validamos que exista el role:
        $validateRole = $model->first();

        // Si existe, realizamos la consulta a la tablas de los modelos 'Professional' y 'Permission':
        if($validateRole){

            // Realizamos la consulta a la tabla del modelo 'Professional': 
            $registers = $model->join('nurses', 'roles.id_role', '=', 'nurses.role_id')

                                // Seleccionamos los campos que se requieren: 
                                ->select('roles.role_name as role', 'nurses.identification', 'nurses.name', 'nurses.last_name', 'nurses.email')

                                // Obtenemos los usuarios que pertenzcan al role: 
                                ->get()

                                // Agrupamos por roles: 
                                ->groupBy('role');

            // Si existen professionales asignados a ese role, los retornamos: 
            if(count($registers) != 0){

                // Declaramos el array 'nurses', para almacenar los professionales con indice numerico: 
                $nurses = [];

                // Iteramos los nurses almacenados en el array 'nurses': 
                foreach($registers as $nurse){

                    // Almacenamos el nurses en el array 'nurses': 
                    $nurses[] = $nurse;

                }

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'nurses' => $nurses], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen enfermeras con ese role.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese role en el sistema.'], status: 404);
        }

    }

    // Metodo para eliminar un registro de la tabla de la DB: 
    public function destroy($role)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $role_name = strtolower($role);

        // Realizamos la consulta a la tabla de la DB:
        $model = Role::where('role_name', $role_name);

        // Validamos que exista el registro en la tabla de la DB:
        $validateRole = $model->first();

        // Si existe, retornamos el registro: 
        if($validateRole){

            try{

                // Elminamos el registro: 
                $model->delete();

                // Retornamos la respuesta:
                return response(content: ['delete' => true], status: 204);

            }catch(Exception $e){
                // Retornamos el error:
                return response(content: ['delete' => false , 'error' => $e->getMessage()], status: 500);
            }

        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' => 'No existe ese role en el sistema.'], status: 404);
        }
    }
}
