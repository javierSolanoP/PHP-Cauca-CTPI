<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Role as ClassRole;
use Illuminate\Http\Request;
use App\Models\Role;
use Exception;
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

    // Metodo para retornar todos los roles con sus respectivos usuarios de la tabla de la DB: 
    public function roles()
    {
       // Realizamos la consulta a la tabla de la DB:
       $model = DB::table('roles');

       // Validamos que exista el role:
       $validateRole = $model->get();

       // Si existe, realizamos la consulta a la tablas de los modelos 'User' y 'Permission':
       if($validateRole){

           // Realizamos la consulta a la tabla del modelo 'User': 
           $registers = $model ->join('usuarios', 'roles.id_role', '=', 'usuarios.role_id')

                               // Seleccionamos los campos que se requieren: 
                               ->select('roles.role_name as role', 'usuarios.identification', 'usuarios.name', 'usuarios.last_name', 'usuarios.email', 'usuarios.telephone')

                               // Obtenemos los usuarios que pertenzcan al role: 
                               ->get()

                               // Agrupamos por roles: 
                               ->groupBy('role');

           // Si existen usuarios asignados a ese role, los retornamos: 
           if(count($registers) != 0){

               // Declaramos el array 'users', para almacenar los usuarios con indice numerico: 
               $users = [];

               // Iteramos los usuarios almacenados en el array 'registers': 
               foreach($registers as $user){

                   // Almacenamos el usuario en el array 'users': 
                   $users[] = $user;

               }

               // Retornamos la respuesta:
               return response(content: ['query' => true, 'roles' => $users], status: 200);

           }else{
               // Retornamos el error:
               return response(content: ['query' => false, 'error' => 'No existen usuarios con ese role.'], status: 404);
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

            // Sino existe, validamos el argumento: 
            if(!$validateRole){

                // Instanciamos la clase 'Role', para validar los argumetos: 
                $role = new ClassRole(role_name: $role_name);

                // Asignamos a la sesion 'validate' la instancia 'role'. Con sus propiedades cargadas de data: 
                $_SESSION['validate'] = $role;

                // Validamos los argumentos: 
                $validateRoleArgm = $role->validateData();

                // Si los argumentos han sido validados, realizamos el registro: 
                if($validateRoleArgm['register']){

                    try{

                        // Realizamos el registro: 
                        Role::create(['role_name' => $role_name]);
                        
                        // Retornamos la respuesta:
                        return response(content: $validateRoleArgm, status: 201);

                    }catch(Exception $e){
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: $validateRoleArgm, status: 403);
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

    // Metodo para retornar los usuarios asignados con un role especifico: 
    public function users($role)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $role_name = strtolower($role);

        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('roles')->where('role_name', $role_name);

        // Validamos que exista el role:
        $validateRole = $model->first();

        // Si existe, realizamos la consulta a la tablas de los modelos 'User' y 'Permission':
        if($validateRole){

            // Realizamos la consulta a la tabla del modelo 'User': 
            $registers = $model ->join('usuarios', 'roles.id_role', '=', 'usuarios.role_id')

                                // Seleccionamos los campos que se requieren: 
                                ->select('roles.role_name as role', 'usuarios.identification', 'usuarios.name', 'usuarios.last_name', 'usuarios.email', 'usuarios.telephone')

                                // Obtenemos los usuarios que pertenzcan al role: 
                                ->get()

                                // Agrupamos por roles: 
                                ->groupBy('role');

            // Si existen usuarios asignados a ese role, los retornamos: 
            if(count($registers) != 0){

                // Declaramos el array 'users', para almacenar los usuarios con indice numerico: 
                $users = [];

                // Iteramos los usuarios almacenados en el array 'registers': 
                foreach($registers as $user){

                    // Almacenamos el usuario en el array 'users': 
                    $users[] = $user;

                }

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'roles' => $users], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen usuarios con ese role.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese role en el sistema.'], status: 404);
        }

    }

    // Metodo para actualizar un registro especifico: 
    // public function update(Request $request, $role)
    // {
    //     // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
    //     $role_name = strtolower($request->input(key: 'role_name'));

    //     // Validamos que los argumentos no esten vacios:
    //     if(!empty($role_name)){

    //         // Realizamos la consulta a la tabla de la DB:
    //         $model = Role::where('role_name', $role);

    //         // Validamos que exista el registro en la tabla de la DB:
    //         $validateRole = $model->first();

    //         // Si existe, validamos el argumento: 
    //         if($validateRole){

    //             // Instanciamos la clase 'Role', para validar los argumetos: 
    //             $role = new ClassRole(role_name: $role_name);

    //             // Asignamos a la sesion 'validate' la instancia 'role'. Con sus propiedades cargadas de data: 
    //             $_SESSION['validate'] = $role;

    //             // Validamos los argumentos: 
    //             $validateRoleArgm = $role->validateData();

    //             // Si los argumentos han sido validados, realizamos el registro: 
    //             if($validateRoleArgm['register']){

    //                 try{

    //                     // Realizamos el registro: 
    //                     Role::create(['role_name' => $role_name]);
                        
    //                     // Retornamos la respuesta:
    //                     return $validateRoleArgm;

    //                 }catch(Exception $e){
    //                     // Retornamos el error:
    //                     return ['register' => false, 'error' => $e->getMessage()];
    //                 }

    //             }else{
    //                 // Retornamos el error:
    //                 return $validateRoleArgm;
    //             }

    //         }else{
    //             // Retornamos el error:
    //             return ['register' => false, 'error' => 'No existe ese role en el sistema.'];
    //         }

    //     }else{
    //         // Retornamos el error:
    //         return ['registrer' => false, 'error' => "Campo 'role_name': NO debe estar vacio."];
    //     }
    // }

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
