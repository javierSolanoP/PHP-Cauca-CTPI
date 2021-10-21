<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\Class\Nurse as ClassNurse;
use App\Models\Nurse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NurseController extends Controller
{
    // Metodo para retornar todos los registros de la tabla de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('nurses')

                // Realizamos la consulta a la tabla del modelo 'Role': 
                ->join('roles', 'roles.id_role', '=', 'nurses.role_id')

                // Seleccionamos los campos que se requiren: 
                ->select('nurses.identification', 'nurses.name', 'nurses.last_name', 'nurses.email', 'roles.role_name as role');

        // Validamos que existan registros en la tabla de la DB:
        $validateUser = $model->get();

        // Si existen, retornamos los registros: 
        if(count($validateUser) != 0){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'nurses' => $validateUser], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen enfermeras en el sistema.'], status: 404);
        }
    }

    // Metodo para registrar una enfermera en la tabla de la DB: 
    public function store(Request $request)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $name      = strtolower($request->input(key: 'name'));
        $last_name = strtolower($request->input(key: 'last_name'));
        $role_name = strtolower($request->input(key: 'role')); 

        // Validamos que los argumentos no esten vacios:
        if(!empty($request->input(key: 'identification'))
        && !empty($name)
        && !empty($last_name)
        && !empty($request->input(key: 'email'))
        && !empty($request->input(key: 'password'))
        && !empty($request->input(key: 'confirmPassword'))
        && !empty($role_name)){

            // Instanciamos el contolador del modelo 'Role'. Para validar que exista el role: 
            $roleController = new RoleController;

            // Validamos que exista el role: 
            $validateRole = $roleController->show(role: $role_name);

            $contentRole = $validateRole->getOriginalContent();

            // Si existe, extraemos su 'id' y validamos que no exista el usuario: 
            if($contentRole['query']){

                // Extraemos su id: 
                $role_id = $contentRole['role']['id'];

                // Realizamos la consulta a la tabla de la DB:
                $model = Nurse::where('identification', $request->input(key: 'identification'));

                // Validamos que exista el registro en la tabla de la DB:
                $validateUser = $model->first();

                // Sino existe, validamos los argumentos: 
                if(!$validateUser){

                    // Instanciamos la clase 'Nurse'. Para validar los argumentos: 
                    $nurse = new ClassNurse(
                                             identification: $request->input(key: 'identification'), 
                                             name: $name,
                                             last_name: $last_name,
                                             email: $request->input(key: 'email'),
                                             password: $request->input(key: 'password'),
                                             confirmPassword: $request->input(key: 'confirmPassword')
                                            );

                    // Asignamos a la sesion 'validate' la instancia 'nurse'. Con sus propiedades cargadas de informacion: 
                    $_SESSION['validate'] = $nurse; 

                    // Validamos los argumentos: 
                    $validateNurseArgm = $nurse->validateData();
 
                    // Si los argumentos han sido validados, realizamos el registro: 
                    if($validateNurseArgm['register']){

                        try{

                            Nurse::create([
                                'identification' => $request->input(key: 'identification'),
                                'name' => $name,
                                'last_name' => $last_name,
                                'email' => $request->input(key: 'email'),
                                'password' => bcrypt($request->input(key: 'password')),
                                'session' => 'Inactiva',
                                'role_id' => $role_id
                            ]);

                            // Retornamos la respuesta:
                            return response(content: $validateNurseArgm, status: 201);

                        }catch(Exception $e){
                            // Retornamos el error:
                            return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                        }

                    }else{
                        // Retornamos el error:
                        return response(content: $validateNurseArgm, status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'Ya existe esa enfermera en el sistema.'], status: 403);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentRole['error']], status: 404);
            }

        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'identification' o 'name' o 'last_name' o 'email' o 'password' o 'confirmPassword' o 'role': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para retornar un enfermera especifico: 
    public function show($identification)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('nurses')

                // Filtramos el usuario requerido: 
                ->where('identification', $identification)

                // Realizamos la consulta a la tabla del modelo 'Role: 
                ->join('roles', 'roles.id_role', '=', 'nurses.role_id')

                // Seleccionamos los campos que se requiren: 
                ->select('nurses.id_nurse as id', 'nurses.identification', 'nurses.name', 'nurses.last_name', 'nurses.email', 'nurses.session',  'nurses.avatar', 'roles.role_name as role');

        // Validamos que exista el registro en la tabla de la DB:
        $validateNurse = $model->first();

        // Si existe, retornamos el registro: 
        if($validateNurse){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'professional' => $validateNurse], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe esa enfermera en el sistema.'], status: 404);
        }
    }

    // Metodo para validar la enfermera en el inicio de sesion: 
    public function login($email)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('nurses')

                // Filtramos el usuario requerido: 
                ->where('email', $email);

        // Validamos que exista el registro en la tabla de la DB:
        $validateNurse = $model->first();

        // Si existe, retornamos el registro: 
        if($validateNurse){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'nurse' => $validateNurse], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe esa enfermera en el sistema.'], status: 404);
        }
    }

    // Metodo para actualizar una enfermera en la tala de la DB: 
    public function update(Request $request, $identification)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $name      = strtolower($request->input(key: 'name'));
        $last_name = strtolower($request->input(key: 'last_name'));
        $role_name = strtolower($request->input(key: 'role')); 
 
        // Validamos que los argumentos no esten vacios:
        if(!empty($name)
        && !empty($last_name)
        && !empty($request->input(key: 'email'))
        && !empty($request->input(key: 'password'))
        && !empty($request->input(key: 'confirmPassword'))
        && !empty($role_name)){
 
            // Instanciamos el contolador del modelo 'Role'. Para validar que exista el role: 
            $roleController = new RoleController;
 
            // Validamos que exista el role: 
            $validateRole = $roleController->show(role: $role_name);

            $contentRole = $validateRole->getOriginalContent();
 
            // Si existe, extraemos su 'id' y validamos que no exista el usuario: 
            if($contentRole['query']){
 
                // Extraemos su id: 
                $role_id = $contentRole['role']['id'];
 
                // Realizamos la consulta a la tabla de la DB:
                $model = Nurse::where('identification', $identification);
 
                // Validamos que exista el registro en la tabla de la DB:
                $validateNurse = $model->first();
 
                // Si existe, validamos los argumentos: 
                if($validateNurse){
 
                    // Instanciamos la clase 'Nurse'. Para validar los argumentos: 
                    $nurse = new ClassNurse(
                                              name: $name,
                                              last_name: $last_name,
                                              email: $request->input(key: 'email'),
                                              password: $request->input(key: 'password'),
                                              confirmPassword: $request->input(key: 'confirmPassword')
                                            );
 
                    // Asignamos a la sesion 'validate' la instancia 'nurse. Con sus propiedades cargadas de informacion: 
                    $_SESSION['validate'] = $nurse; 
 
                    // Validamos los argumentos: 
                    $validateNurseArgm = $nurse->validateData();
  
                    // Si los argumentos han sido validados, realizamos el registro: 
                    if($validateNurseArgm['register']){
 
                        try{
 
                            $model->update(['name' => $name,
                                            'last_name' => $last_name,
                                            'email' => $request->input(key: 'email'),
                                            'password' => bcrypt($request->input(key: 'password')),
                                            'role_id' => $role_id]);
 
                            // Retornamos la respuesta:
                            return response(content: $validateNurseArgm, status: 201);
 
                        }catch(Exception $e){
                            // Retornamos el error:
                            return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                        }
 
                    }else{
                        // Retornamos el error:
                        return response(content: $validateNurseArgm, status: 403);
                    }
 
                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'No existe esa enfermera en el sistema.'], status: 404);
                }
 
            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentRole['error']], status: 404);
            }
 
        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'name' o 'last_name' o 'email' o 'password' o 'confirmPassword' o 'role': NO deben estar vacios."], status: 403);
        }
    }

    // Metodo para actualizar la sesion de la enfermera: 
    public function updateSession($email, $session)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Nurse::where('email', $email);

        // Validamos que exista el registro en la tabla de la DB:
        $validateNurse = $model->first();

        // Si existe, actualizamos la sesion: 
        if($validateNurse){

            try{

                // Actualizamos la sesion: 
                $model->update(['session' => $session]);

                // Retornamos la respuesta:
                return response(content: ['update' => true], status: 204);

            }catch(Exception $e){
                // Retornamos el error:
                return response(content: ['update' => false, 'error' => $e->getMessage()], status: 500);
            }

        }else{
            // Retornamos el error:
            return response(content: ['update' => false, 'error' => 'No existe esa enfermera en el sistema.'], status: 404);
        }
    }

    // Metodo para aniadir la URL del avatar de la enfermera: 
    public function addAvatar($email, $url)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Nurse::where('email', $email);

        // Validamos que exista el registro en la tabla de la DB:
        $validateNurse = $model->first();

        // Si existe, actualizamos el campo 'avatar' de la tabla de la DB: 
        if($validateNurse){

            try{

                // Actualizamos el campo 'avatar': 
                $model->update(['avatar' => $url]);

                // Retornamos la respuesta:
                return response(content: ['add' => true], status: 204); 

            }catch(Exception $e){
                // Retornamos el error:
                return response(content: ['add' => false, 'error' => $e->getMessage()], status: 500);
            }

        }else{
            // Retornamos el error:
            return response(content: ['add' => false, 'error' => 'No existe esa enfermera en el sistema.'], status: 404);
        }
    }

    // Metodo para eliminar una enfermera de la tabla de la DB: 
    public function destroy($identification)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Nurse::where('identification', $identification);

        // Validamos que exista el registro en la tabla de la DB:
        $validateNurse = $model->first();

        // Si existe, eliminamos el registro: 
        if($validateNurse){

            try{

                // Eliminamos el registro: 
                $model->delete();

                // Retornamos la respuesta:
                return response(content: ['delete' => true], status: 204);

            }catch(Exception $e){
                // Retornamos el error:
                return response(content: ['delete' => false, 'error' => $e->getMessage()], status: 500);
            }

        }else{
            // Retornamos el error:
            return response(content: ['delete' => false, 'error' => 'No existe esa enfermera en el sistema.'], status: 404);
        }
    }
}
