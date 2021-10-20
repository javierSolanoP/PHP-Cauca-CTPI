<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\Class\Professional as ClassProfessional;
use App\Http\Controllers\RoleController;
use App\Models\Professional;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessionalController extends Controller
{
    // Metodo para retornar todos los registros de la tabla de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('professionals')

                // Realizamos la consulta a la tabla del modelo 'Role': 
                ->join('roles', 'roles.id_role', '=', 'professionals.role_id')

                // Seleccionamos los campos que se requiren: 
                ->select('professionals.identification', 'professionals.name', 'professionals.last_name', 'professionals.email', 'roles.role_name as role');

        // Validamos que existan registros en la tabla de la DB:
        $validateUser = $model->get();

        // Si existen, retornamos los registros: 
        if(count($validateUser) != 0){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'users' => $validateUser], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existen profesionales en el sistema.'], status: 404);
        }
    }

    // Metodo para registrar un usuario en la tabla de la DB: 
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
                $model = Professional::where('identification', $request->input(key: 'identification'));

                // Validamos que exista el registro en la tabla de la DB:
                $validateUser = $model->first();

                // Sino existe, validamos los argumentos: 
                if(!$validateUser){

                    // Instanciamos la clase 'professional'. Para validar los argumentos: 
                    $professional = new ClassProfessional(
                                             identification: $request->input(key: 'identification'), 
                                             name: $name,
                                             last_name: $last_name,
                                             email: $request->input(key: 'email'),
                                             password: $request->input(key: 'password'),
                                             confirmPassword: $request->input(key: 'confirmPassword')
                                            );

                    // Asignamos a la sesion 'validate' la instancia 'professional'. Con sus propiedades cargadas de informacion: 
                    $_SESSION['validate'] = $professional; 

                    // Validamos los argumentos: 
                    $validateProfessionalArgm = $professional->validateData();
 
                    // Si los argumentos han sido validados, realizamos el registro: 
                    if($validateProfessionalArgm['register']){

                        try{

                            Professional::create([
                                'identification' => $request->input(key: 'identification'),
                                'name' => $name,
                                'last_name' => $last_name,
                                'email' => $request->input(key: 'email'),
                                'password' => bcrypt($request->input(key: 'password')),
                                'session' => 'Inactiva',
                                'role_id' => $role_id
                            ]);

                            // Retornamos la respuesta:
                            return response(content: $validateProfessionalArgm, status: 201);

                        }catch(Exception $e){
                            // Retornamos el error:
                            return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                        }

                    }else{
                        // Retornamos el error:
                        return response(content: $validateProfessionalArgm, status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'Ya existe ese profesional en el sistema.'], status: 403);
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

    // Metodo para retornar un usuario especifico: 
    public function show($identification)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('professionals')

                // Filtramos el usuario requerido: 
                ->where('identification', $identification)

                // Realizamos la consulta a la tabla del modelo 'Role: 
                ->join('roles', 'roles.id_role', '=', 'professionals.role_id')

                // Seleccionamos los campos que se requiren: 
                ->select('professionals.id_professional as id', 'professionals.identification', 'professionals.name', 'professionals.last_name', 'professionals.email', 'professionals.session', 'roles.role_name as role');

        // Validamos que exista el registro en la tabla de la DB:
        $validateUser = $model->first();

        // Si existe, retornamos el registro: 
        if($validateUser){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'professional' => $validateUser], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese profesional en el sistema.'], status: 404);
        }
    }

    // Metodo para validar el usuario en el inicio de sesion: 
    public function login($email)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = DB::table('professionals')

                // Filtramos el usuario requerido: 
                ->where('email', $email);

        // Validamos que exista el registro en la tabla de la DB:
        $validateUser = $model->first();

        // Si existe, retornamos el registro: 
        if($validateUser){

            // Retornamos la respuesta:
            return response(content: ['query' => true, 'professional' => $validateUser], status: 200);

        }else{
            // Retornamos el error:
            return response(content: ['query' => false, 'error' => 'No existe ese profesional en el sistema.'], status: 404);
        }
    }

    // Metodo para actualizar un usuario en la tala de la DB: 
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
                $model = Professional::where('identification', $identification);
 
                // Validamos que exista el registro en la tabla de la DB:
                $validateUser = $model->first();
 
                // Si existe, validamos los argumentos: 
                if($validateUser){
 
                    // Instanciamos la clase 'professional'. Para validar los argumentos: 
                    $professional = new ClassProfessional(
                                              name: $name,
                                              last_name: $last_name,
                                              email: $request->input(key: 'email'),
                                              password: $request->input(key: 'password'),
                                              confirmPassword: $request->input(key: 'confirmPassword')
                                            );
 
                    // Asignamos a la sesion 'validate' la instancia 'Professional. Con sus propiedades cargadas de informacion: 
                    $_SESSION['validate'] = $professional; 
 
                    // Validamos los argumentos: 
                    $validateProfessionalArgm = $professional->validateData();
  
                    // Si los argumentos han sido validados, realizamos el registro: 
                    if($validateProfessionalArgm['register']){
 
                        try{
 
                            $model->update(['name' => $name,
                                            'last_name' => $last_name,
                                            'email' => $request->input(key: 'email'),
                                            'password' => bcrypt($request->input(key: 'password')),
                                            'role_id' => $role_id]);
 
                            // Retornamos la respuesta:
                            return response(content: $validateProfessionalArgm, status: 201);
 
                        }catch(Exception $e){
                            // Retornamos el error:
                            return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
                        }
 
                    }else{
                        // Retornamos el error:
                        return response(content: $validateProfessionalArgm, status: 403);
                    }
 
                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => 'No existe ese profesional en el sistema.'], status: 404);
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

    // Metodo para actualizar la sesion del usuario: 
    public function updateSession($email, $session)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Professional::where('email', $email);

        // Validamos que exista el registro en la tabla de la DB:
        $validateUser = $model->first();

        // Si existe, actualizamos la sesion: 
        if($validateUser){

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
            return response(content: ['update' => false, 'error' => 'No existe ese profesional en el sistema.'], status: 404);
        }
    }

    // Metodo para aniadir la URL del avatar del usuario: 
    public function addAvatar($email, $url)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Professional::where('email', $email);

        // Validamos que exista el registro en la tabla de la DB:
        $validateUser = $model->first();

        // Si existe, actualizamos el campo 'avatar' de la tabla de la DB: 
        if($validateUser){

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
            return response(content: ['add' => false, 'error' => 'No existe ese profesional en el sistema.'], status: 404);
        }
    }

    // Metodo para eliminar un usuario de la tabla de la DB: 
    public function destroy($identification)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Professional::where('identification', $identification);

        // Validamos que exista el registro en la tabla de la DB:
        $validateUser = $model->first();

        // Si existe, eliminamos el registro: 
        if($validateUser){

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
            return response(content: ['delete' => false, 'error' => 'No existe ese profesional en el sistema.'], status: 404);
        }
    }
}

