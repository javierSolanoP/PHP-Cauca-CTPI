<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;



class GeneralController extends Controller
{
    ////metodo para ver que modulos pertenecen a un rol
    public function modulesRoles($role){

        //convertimos el role a minuscula
        $role_name = strtolower($role);
        
        
        //comprobamos que el role exista en la BD
        $model = Role::select('role_name as role')->where('role_name', $role_name);
        
        //validamos que haya registro en la base de datos
        $validateRole = $model->first();
        //return $model->first();

        //si existe el rol:
        if ($validateRole) {
            
            //realizamos la consulta filtrando por el modulpo
            $modules = DB::table('modules')

                //filtramos por el role
                ->where('role_name', $role_name)

                //realizamos la consulta a la tabla 'module_roles'
                ->join('module_roles', 'module_roles.module_id', '=', 'modules.id_module')
                ->join('roles', 'roles.id_role', '=', 'module_roles.role_id')
                ->leftJoin('endpoints', 'endpoints.module_id', '=', 'modules.id_module')
                ->select('modules.module', 'roles.role_name', 'endpoints.endpoint')

                ->get()

                ->groupBy('role_name');

                //si existen roles con ese modulo los asignamos
                if (count($modules) != 0) {
                    
                    //declaramos el array rolesModulos
                    $rolesModulos = [];

                    return $modules;
                    //iteramos los modulos almacenados en el array  'modules'
                    foreach ($modules as $module) {
                        
                        //almacenamos el modulo en el array
                        $rolesModulos[] = $module;
                    }

                    //retornamos la respuesta con los modulos
                    return response(content: ['query' => 'true', 'modulos' => $rolesModulos], status:200);
                }

        }else{

            //retornamos el error
            return response(content: ['query' => 'false', 'error' => 'El role ingresado no existe']);
        }

    }
}
