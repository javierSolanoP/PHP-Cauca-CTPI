<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Http\Controllers\Permiso as ClassPermiso;
use App\Http\Controllers\RoleController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller
{
    // Metodo para retornar todos los registros de la tabla de la DB: 
    public function index()
    { 
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('permisos')

                // Realizamos la consulta a la tabla del modelo 'Permission': 
                ->join('roles', 'roles.id_role', '=', 'permisos.role_id')

                // Seleccionamos los campos que se requieren: 
                ->select('permisos.permission_name as permission', 'roles.role_name as role');

        // Validamos que existan los registro en la tabla de la DB:
        $validatePemission = $model->get();

        // Si existe, retornamos el registro: 
        if(count($validatePemission) != 0){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'permissions' => $validatePemission], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen permisos en el sistema.'], status: 404);
        }

    }

    // Metodo para retornar todos los permisos agrupados por roles: 
    public function roles()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('permisos');

        // Validamos que existan los registro en la tabla de la DB:
        $validatePemission = $model->get();

        // Si existe, agrupamos los permisos por roles y retornamos los registros: 
        if(count($validatePemission) != 0){

            // Realizamos la consulta a la tabla del modelo 'Role': 
            $registers = $model->join('roles', 'roles.id_role', '=', 'permisos.role_id')

                                // Seleccionamos los campos que se requieren: 
                                ->select('permisos.permission_name as permission', 'roles.role_name as role')

                                // Obtenemos todos los permisos: 
                                ->get()
                                
                                // Agrupamos los permisos por roles:
                                ->groupBy('role');

            // Declaramos el array 'roles', para almacenar los roles con indice numerico: 
            $roles = [];

            // Iteramos los usuarios almacenados en el array 'registers': 
            foreach($registers as $role){

                // Almacenamos el role en el array 'roles': 
                $roles[] = $role;

            }

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'roles' => $roles], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen permisos en el sistema.'], status: 404);
        }
    }

    // Metodo para registrar un permiso en la tabla de la DB: 
    public function store(Request $request)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $permission_name = strtolower($request->input(key: 'permission_name'));
        $role_name       = strtolower($request->input(key: 'role_name'));

        // Validamos que los argumentos no esten vacios:
        if(!empty($permission_name) && !empty($role_name)){

            // Instanciamos el controlador del modelo 'Role', para validar que exista el role: 
            $roleController = new RoleController;

            // Validamos que exista el role: 
            $validateRole = $roleController->show(role: $role_name);

            $contentRole = $validateRole->getOriginalContent();

            // Si existe, extraemos su 'id' y validamos que no exista ese permiso: 
            if($contentRole['query']){

                // Extraemos el id el role: 
                $role_id = $contentRole['role']['id'];

                // Realizamos la consulta a la tabla de la DB:
                $model = Permiso::where('permission_name', $permission_name)->where('role_id', $role_id);

                // Validamos que no exista el registro en la tabla de la DB:
                $validatePemission = $model->first();

                // Sino existe, validamos los argumentos: 
                if(!$validatePemission){

                    // Instanciamos la clase 'Permiso', para validar los argumentos:
                    $permission = new ClassPermiso(permission_name: $permission_name);
                    
                    // Asignamos a la sesion 'validate' la instancia 'permission'. Con sus propiedades cargadas de informacion: 
                    $_SESSION['validate'] = $permission;

                    // Validamos el argmumento: 
                    $validatePemissionArgm = $permission->validateData();

                    // Si los argumentos han sido validados, realizamos el registro: 
                    if($validatePemissionArgm['register']){

                        try{

                            // Realizamos el registro:
                            Permiso::create(['permission_name' => $permission_name,
                                             'role_id' => $role_id]);

                            // Retornamos la respuesta:
                            return response(content: $validatePemissionArgm, status: 201);

                        }catch(Exception $e){
                            // Retornamos el error:
                            return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                        }

                    }else{
                        // Retornamos el error:
                        return response(content: $validatePemissionArgm, status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'Ya existe ese permiso en el sistema.'], status: 403);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentRole['error']], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'permission_name' o 'role_name': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar un permiso de un role especifico: 
    public function show($role)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $role_name = strtolower($role);

        // Instanciamos el controlador del modelo 'Role'. Para validar que exista el role: 
        $roleController = new RoleController; 

        // Validamos que exista el role: 
        $validateRole = $roleController->show(role: $role_name);

        $contentRole = $validateRole->getOriginalContent();

        // Si existe, realizamos la consulta a la DB: 
        if($contentRole['query']){

            // Realizamos la consulta a la tabla de la DB:
            $model = DB::table('roles')

                    // Filtramos el registro requerido:
                    ->where('role_name', $role_name)

                    // Realizamos la consulta a la tabla del modelo 'Permission': 
                    ->join('permisos', 'roles.id_role', '=', 'permisos.role_id')

                    // Seleccionamos los campos que se requieren: 
                    ->select('permisos.permission_name as permission', 'roles.role_name as role');

            // Validamos que existan los registro en la tabla de la DB:
            $validatePemission = $model->get();

            // Si existe, retornamos el registro: 
            if(count($validatePemission) != 0){

                // Retornamos la respuesta:
                return response(content: ['query' => true, 'permission' => $validatePemission], status: 200);

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen permisos para ese role en el sistema.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => $contentRole['error']], status: 404);
        }

    }

    // Metodo para retornar todos los permisos de un role especifico: 
    public function permissions($role)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $role_name = strtolower($role);

        // Instanciamos el controlador del modelo 'Role'. Para validar que exista el role: 
        $roleController = new RoleController; 

        // Validamos que exista el role: 
        $validateRole = $roleController->show(role: $role_name);

        $contentRole = $validateRole->getOriginalContent();

        // Si existe, extraemos su 'id' y realizamos la consulta a la DB: 
        if($contentRole['query']){

            // Extraemos el id:
            $role_id = $contentRole['role']['id'];
            
            // Realizamos la consulta a la tabla de la DB:
            $model = DB::table('permisos')

                    // Filtramos el registro requerido:
                    ->where('role_id', $role_id);

            // Validamos que existan los registro en la tabla de la DB:
            $validatePemission = $model->get();

            // Si existe, agrupamos los permisos por roles y retornamos los registros: 
            if(count($validatePemission) != 0){

                // Realizamos la consulta a la tabla del modelo 'Permission':
                $registers = $model->join('roles', 'roles.id_role', '=', 'permisos.role_id')
                       
                                    // Seleccionamos los campos que se requieren: 
                                    ->select('permisos.permission_name as permission', 'roles.role_name as role')

                                    // Obtenemos todos los permisos: 
                                    ->get();

            
                // Si existen usuarios asignados a ese role, los retornamos: 
                if(count($registers) != 0){

                    // Declaramos el array 'permissions', para almacenar los permissions con indice numerico: 
                    $permissions = [];

                    // Iteramos los usuarios almacenados en el array 'registers': 
                    foreach($registers as $permission){

                        // Almacenamos el role en el array 'permissions': 
                        $permissions[] = $permission;

                    }

                    // Retornamos la respuesta:
                    return response(content: ['query' => true, 'permissions' => $permissions], status: 200);

                }else{
                    // Retornamos el error:
                    return response(content: ['query' => false, 'error' => 'No existen permisos con ese role.'], status: 404);
                }

            }else{
                // Retornamos el error:
                return response(content: ['query' => false, 'error' => 'No existen permisos en el sistema.'], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => $contentRole['error']], status: 404);
        }
        
    }

    // Metodo para eliminar un permiso: 
    public function destroy($permission, $role)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $permission_name = strtolower($permission);
        $role_name       = strtolower($role);

        // Instanciamos el controlador del modelo 'Role'. Para validar que exista el role: 
        $roleController = new RoleController; 

        // Validamos que exista el role: 
        $validateRole = $roleController->show(role: $role_name);

        $contentRole = $validateRole->getOriginalContent();

        // Si existe, extraemos su 'id' y realizamos la consulta a la DB: 
        if($contentRole['query']){

            // Extraemos su id: 
            $role_id = $contentRole['role']['id'];

            // Realizamos la consulta a la tabla de la DB:
            $model = Permiso::where('permission_name', $permission_name)->where('role_id', $role_id);

            // Validamos que exista el registro en la tabla de la DB:
            $validatePemission = $model->first();

            // Si existe, realizamos la eliminacion: 
            if($validatePemission){

                try{

                    // Eliminamos el registro del permiso: 
                    $model->delete();

                    // Retornamos la respuesta:
                    return response(content: ['delete' => true], status: 204);

                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
                }

            }else{
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => 'No existe ese permiso en el sistema.'], status: 404);
            }   

        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error'=> $contentRole['error']], status: 404);
        }

    }
}
