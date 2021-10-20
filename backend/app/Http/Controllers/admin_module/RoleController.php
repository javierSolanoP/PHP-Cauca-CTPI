<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\Class\Role as ClassRole;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller{

    //metodo para retornar todos los registtros de la tabla de la BD
    public function index(){

        //consulta a la base de datos
        $model = Role::select('role_name as role')->get();

        //validamos que existan registros en la tabla de la bd
        $validateRole = $model->get();

        if (count($validateRole) != 0) {

            //retornamos la respuesta
            return response(content: ['query' => true, 'roles' => $model], status:200);
        }else{

            return response(content: ['query' => false, 'error' => 'no existen roles en el sistema']);

        }


    }

    //metodo para retornar un objeto especifico
    public function show($role){

        //convertimos el argumento en minusculas
        $nombre_role = strtolower($role);

        //realizamos la consulta a la tabla de la BD
        $model = Role::select('id_role', 'role_name as role')->where('role_name', $nombre_role);

        //validamos que exista el registro en la tabla de la BD:
        $validateRole = $model->first();

        //si existe lo retornamos
        if ($validateRole) {
            
            //retornamos la respuesta
            return response(content: ['query' => true, 'role' => $validateRole], status:200);

        }else{

            //retornamos la respuesta
            return response(content: ['query' => false, 'error' => 'No existe ese role en el sistema'], status:404);

        }
    }

    public function store(Request $request){

        //convertimos el argumento en minuscula
        $role_name = strtolower($request->input(key: 'role_name'));

        //validamos que los argumentos no esten vacios
        if (!empty($role_name)) {
            
            //consultamos en la base de datos
            $model = Role::where('role_name', $role_name);

            //validamos que exista el registro en la tabla de la BD
            $validateRole = $model->first();

            if (!$validateRole) {
                
                //instanciamos la clase 'Role, para validar los argumentos
                $role = new ClassRole(role_name: $role_name);

                //Asignamos a la sesión 'validate la instancia 'role. Con sus propiedades cargadas de data
                $_SESSION['validate'] = $role;

                //
                try {

                    //registro del rol
                    Role::create(['role_name' => $role_name]);

                    //retorno de la respuesta
                    return response(content: ['query' => 'role ingresado'], status:201);

                }catch (Exception $e) {
                    
                    //retornamos el error
                    return response(content: ['query' => false, 'error' => $e->getMessage()], status:500);

                }

            }else{

                //retornamos el error
                return response(content: ['query' => false, 'error' => 'el rol ya existe en el sistema'], status:500);

            }


        }

    }

    public function destroy($role){

        //pasamos el argumento a minuscula
        $nombre_role = strtolower($role);

        //hacemos la consulta a la tabla de la BD
        $model = Role::where('role_name', $nombre_role);

        //validamos que exista el registro en la tabla de la bd
        $validateRole = $model->first();

        if ($validateRole) {

            try {
                //elminamos el registro de la tabla de la bd
                $model->delete();

                //retornamos el error
                return response(content: ['delete' => true], status:204);

            } catch (Exception $e) {

                //retornamos la respuesta
                return ['error' => true, 'error' => $e->getMessage()];
            }
            
        }else{

            //retornamos el error
            return response(content: ['delete' => false, 'error' => 'No existe ese role en el sistema'], status:404);

        }

    }


}