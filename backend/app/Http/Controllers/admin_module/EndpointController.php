<?php
namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;



class EndpointController extends Controller{


    //metodo para ver que modulos pertenecen a un rol
    public function modulesRoles($role){

        //convertimos el role a minuscula
        $role_name = strtolower($role);
        
        
        //comprobamos que el role exista en la BD
        $model = Role::select('role_name as role');
        
        //validamos que haya registro en la base de datos
        $validateRole = $model->first();
        //return $validateRole;

        //si existe el rol:
        if ($validateRole) {
            
            //realizamos la consulta filtrando por el modulpo
            $modules = DB::table('modules')

                //filtramos por el role
                ->where('role_name', $role_name)

                //realizamos la consulta a la tabla 'module_roles'
                ->join('module_roles', 'module_roles.module_id', '=', 'modules.id_module')
                ->join('roles', 'roles.id_role', '=', 'module_roles.role_id')
                ->select('modules.module', 'roles.role_name')

                ->get()

                ->groupBy('role');

                //si existen roles con ese modulo los asignamos
                if (count($modules) != 0) {
                    
                    //declaramos el array rolesModulos
                    $rolesModulos = [];

                    //iteramos los modulos almacenados en el array  'modules'
                    foreach ($modules as $module) {
                        
                        //almacenamos el modulo en el array
                        $rolesModulos[] = $module;
                    }

                    return response(content: ['query' => 'true', 'modulos' => $rolesModulos], status:200);


                }

        }else{

            //retornamos el error
            return response(content: ['query' => 'false', 'error' => 'El role ingresado no existe']);

        }

    }
    
}

