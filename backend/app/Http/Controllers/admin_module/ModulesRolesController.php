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
        $module = strtolower($request->input('module'));

        //validamos que los argumentos no esten vacios
        if (!empty($role_name) && !empty($module)) {

            $roleController = new RoleController;
            $moduleController = new ModuleController;

            $validateRole = $roleController->show(role: $role_name);
            $validateModule = $moduleController->show(module: $module);

            //extraemos el contenido de las respuetas
            $contentValidateRole = $validateRole->getOriginalContent();
            $contentValidateModel = $validateModule->getOriginalContent();


            //si existen, extraemos sus id
            if ($contentValidateRole['query']) {

                if ($contentValidateModel['query']) {
                    
                    //extraemos los id
                    $rolId = $contentValidateRole['role']->id;
                    $moduleId = $contentValidateModel['module']['id'];

                    //realizamos la consulta a la tabla de la bd
                    $model = ModuleRole::where('module_id', $moduleId)->where('role_id', $rolId);

                    $validateRoleModule = $model->first();


                     //si no existe realizamos el registro
                    if (!$validateRoleModule) {
                        

                        try {
                            //insertamos los datos en la tabla de la base de datos
                            ModuleRole::create([
                                'role_id' => $rolId,
                                'module_id' => $moduleId
                            ]);

                            //retornamos la respuesta satisfactoria
                            return response(content: ['register' => true], status: 201);

                        } catch (Exception $e) {
                            
                            //retornamos el error
                            return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                        }

                    }else{

                        //retornamos el error
                        return response(content: ['register' => false, 'error' => 'Ya existe este registro'],status:403);
                    }

                }
            }
              
        }else{

            //retornamos el error de que los campos están vacios
            return response(content: ['register' => false, 'error' => 'los campos no deben estar vacios'], status: 403);
        }

    }


    public function destroy($roleName, $moduleName){

        $roleName = strtolower($roleName);
        $moduleName = strtolower($moduleName);

        //instanciamos el controlador de modelo 'ModuleRoles', para validar que exista 
        $roleController = new RoleController;
        $moduleController = new ModuleController;

        //extraemos el contenido de la respuesta
        $validateRole = $roleController->show(role: $roleName);
        $validateModule = $moduleController->show(module: $moduleName);

        //extraemos el contenido de las respuetas
        $contentValidateRole = $validateRole->getOriginalContent();
        $contentValidateModel = $validateModule->getOriginalContent();
        
        //si existe extraemos su id y realizamos la consulta a la DB:
        if ($contentValidateRole['query']) {

            if ($contentValidateModel['query']) {
            
                //extraemos los id
                $rolId = $contentValidateRole['role']->id;
                $moduleId = $contentValidateModel['module']['id'];

                //realizamos la consulta a la tabla de la bd
                $model = ModuleRole::where('module_id', $moduleId)->where('role_id', $rolId);

                $validateRoleModule = $model->first();

                if ($validateRoleModule) {
                    try {
                        //eliminamos el modulo_rol
    
                        $model->delete();
    
                        //retornamos la respuesta
                        return response(content: ['query' => true], status: 204);
    
                    } catch (Exception $e) {
                        
                        //retornamos el eror
                        return response(content: ['query' => false, 'error' => $e->getMessage()]);
                    }
                }

            }else{
                //retornamos el error
                return response(content: ['query' => false, 'error' => 'no existe ese regsitro']);
            }

        }else{
            //retornamos la rspuesta
            return response(content: ['register' => false, 'error' => 'los datos ingresados no se encuentran en el sistema'], status: 404);
        }


    }


}
