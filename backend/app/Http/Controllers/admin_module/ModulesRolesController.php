<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModuleRole;
use Illuminate\Support\Facades\DB;
use Exception;

class ModulesRolesController extends Controller
{
    //meotodo para listar los modulos y roles
    public function index(){

        //traemos los modulos y roles de la tabla 'module_roles'
        $modulosRoles = DB::table('roles')
                        ->join('module_roles', 'module_roles.role_id', '=', 'roles.id_role')
                        ->join('modules', 'modules.id_module', '=', 'module_roles.module_id')
                        ->select('roles.role_name', 'modules.module')
                        ->get();

        //validamos si existen reistros en la tabla 'module_roles'
        if (count($modulosRoles) != 0) {
            
            //retornamos los modulos
            return response(content: ['query' => true, 'Modulos y roles' => $modulosRoles]);

        }else{

            //retornamos el error
            return response(content: ['query' => false, 'No existen registros en la tabla module_roles']);
        }
        
    
    }

    //metodo para asignar un modulo a un rol
    public function store(Request $request){

        //converitmos los argumentos a minusculas
        $role_name = strtolower($request->input('role_name'));
        $module_name = strtolower($request->input('module_name'));

        //validamos que los argumentos no esten vacios
        if (!empty($role_name) && !empty($module_name)) {

            //consultamos a la base de datos y extraemos el id de cada uno
            $idRol = DB::table('roles')
                    ->where('role_name', $role_name)
                    ->select('id_role')
                    ->get();

            $idModulo = DB::table('modules')
                    ->where('module', $module_name)
                    ->select('id_module')
                    ->get();

            
            
            

        }   


        
        


    }


}
