<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\Class\Modules as ClassModules;
use App\Http\Controllers\Require\Trait\MethodModule;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;

class ModuleController extends Controller{

    //metodo para mostrar los modulos
    public function index(){

        //hacemos la consulta a la base de satos
        $model = Module::select('module as module_name');

        //validamos que haya registros en la base de datos
        $validateModule = $model->get();

        
        if (count($validateModule) != 0) {
            
            //retornamos la respuesta
            return response(content:['query' => true, 'modulos' => $validateModule], status:200);
        }else{

            //retornamos el error
            return response(content: ['query' => false, 'error' => 'no hay registros en el sistema'], status: 404);

        }

    }

    //metodo para agregar un modulo
    public function store(Request $request){

        //convertimos a minuscula el argumento
        $module_name = strtolower($request->input('module_name'));

        //validamos que el arguemnto no este vacio
        if (!empty($request->input('module_name'))) {
            
            //se realiza la consulta a la base de datos
            $model = Module::where('module', $request->input('module_name'));

            //validamos que exista el registro en la base de datos
            $validateModule = $model->first();

            //sino existe, validamos los argumentos recibidos:
            if (!$validateModule) {
                
                //instanciamos la clase 'Modules', para validar los argumentos
                $module = new ClassModules(module_name: $module_name);

                //asignamos a la sesion 'validate' la instancia 'modules'. Con sus propiedades
                $_SESSION['validate'] = $module;

                //validamos los argumentos
                $validateModuleArg = $module->validateData();

                //si los argumentos han sido validados
                if ($validateModuleArg['register']) {
                    
                    try {
                        //Creamos el modulo
                        Module::create(['module' => $module_name]);

                        //retornamos la respuesta
                        return response(content: ['query' => 'modulo registrado'], status: 201);

                    } catch (Exception $e) {

                        //retornamos el error
                        return response(content: ['query' => false, 'error' => $e->getMessage()], status: 500);

                    }
                }else{

                    //retornamos el error
                    return response(content: ['query' => false, 'error' => 'el modulo ya existe en el sistema']);
                }
            }
        }else{
            return response(content: ['register' => false, 'error' => 'el campo module no debe estar vacio']);
        }

    }

    public function show($module){

        //convertimos el argumento a minuscula
        $module_name = strtolower($module);

        //realizamos la consulta a la tabla de la BD
        $model = Module::select('id_module', 'module_name as module')->where('module', $module);

        //validamos que exista el rgistro en la base de datos
        $validateModule = $model->first();

        //si existe lo retornamos
        if ($validateModule) {
            
            //retornamos la respuestaa
            return response(content: ['query' => true, 'module' => $validateModule]);
        }else{

            //retornamos el error
            return response(content: ['query' => false, 'error' => 'No existe ese role en el sistema']);
        }
    }

    //meotodo para eliminar un modulo
    public function destroy($module){

        //pasamos el argumento a minuscula
        $module_name = strtolower($module);

        //realizamos la consulta a la base de datos
        $model = Module::where('module', $module_name);

        //validamos que exista el registro en la tabla de la BD
        $validateModule = $model->first();

        //si existe retornamos la información
        if ($validateModule) {
            
            try {
                //elminamos el registro
                $model->delete();

                //retornamos la respuesta
                return response(status: 204);

            } catch (Exception $e) {
                
                //retornamos el error
                return response(content: ['delete' => false, 'error' => 'No existe ese modulo en el sistema']);
            }
            

        }

    }


}