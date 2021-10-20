<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
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
          $registers = $model ->join('professionals', 'roles.id_role', '=', 'professionals.role_id')

                              // Seleccionamos los campos que se requieren: 
                              ->select('roles.role_name as role', 'professionals.identification', 'professionals.name', 'professionals.last_name', 'professionals.email')

                              // Obtenemos los professional que pertenzcan al role: 
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
              return response(content: ['query' => false, 'error' => 'No existen professionales con ese role.'], status: 404);
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

           // Sino existe, realizamos el registro: 
           if(!$validateRole){
                try{

                    // Realizamos el registro: 
                    Role::create(['role_name' => $role_name]);
                       
                    // Retornamos la respuesta:
                    return response(content: ['register' => true], status: 201);

                }catch(Exception $e){
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $e->getMessage()], status: 500);
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
   public function professionals($role)
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
           $registers = $model->join('professionals', 'roles.id_role', '=', 'professionals.role_id')

                               // Seleccionamos los campos que se requieren: 
                               ->select('roles.role_name as role', 'professionals.identification', 'professionals.name', 'professionals.last_name', 'professionals.email')

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
               return response(content: ['query' => false, 'error' => 'No existen profesionales con ese role.'], status: 404);
           }

       }else{
           // Retornamos el error:
           return response(content: ['query' => false, 'error' => 'No existe ese role en el sistema.'], status: 404);
       }

   }

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
=======
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
>>>>>>> 4c4960eda2fa61159b50d2d6bfd620ef3e4fb769
