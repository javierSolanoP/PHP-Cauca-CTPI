<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\controllers\UsuarioController;
use App\Http\Controllers\Usuario as ClassUsuario;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    //Metodo para procesar las peticiones recibidas por 'HTTP': 
    public function store(Request $request)
    {
        //Formulario de la peticion: 
        $form = $request->input(key: 'form');

        //Tipos de formularios: 

        //Formulario de inicio de sesion de cliente: 
        static $login           = 'login';

        //Formulario de restablecimiento de contrasenia, cliente: 
        static $restorePassword = 'restorePassword';

        //Formulario de cerrar sesion de cliente: 
        static $closeLogin      = 'closeLogin';

        //Instanciamos el controlador de la clase 'Usuarios', para validar la existencia del usuario y actualizar sus estados de sesion y contrasenia: 
        $usersController = new UsuarioController;

        $content =  $usersController->show(email: 'jmsolano24@misena.edu.co');

        $user = $content->getOriginalContent();

        return ['response' => $user['user']];

        // //Validamos que exista el usuario en la DB: 
        // $validateUser = $usersController->show(email: $request->input(key: 'email'));

        // switch($form){

        //     case $login: 

        //        //Si existe, extraemos su estado de sesion actual: 
        //        if($validateUser['Query']){

        //             //Estado de sesion: 
        //             //-----------------
        //             //Sesion inactiva: 
        //             static $inactive = 'Inactiva';
        //             //Sesion activa: 
        //             static $active   = 'Activa';
        //             //Sesion pendiente: 
        //             static $pending  = 'Pendiente';

        //             if($validateUser['User']['sesion'] == $inactive){

        //                 //Realizamos la actualizacion del estado de la sesion: 
        //                 $usersController->updateSession(email: $request->input(key: 'email'),
        //                                                 session: $active);

        //                 //Realizamos una nueva consulta al controlador de 'Usuarios', para cargar el nuevo estado de sesion: 
        //                 $user = $usersController->show(email: $request->input(key: 'email'));
        //                 //Retornamos la respuesta: 
        //                 return ['Login' => true, 'User' => $user['User']];

        //             }elseif($validateUser['User']['sesion'] == $active){
        //                 //Retornamos el error: 
        //                 return ['Login' => false, 'Error' => 'Este usuario ya inicio sesion en el sistema.'];
                    
        //             }elseif($validateUser['User']['sesion'] == $pending){
        //                 //Retornamos el error: 
        //                 return ['Login' => false, 'Error' => 'Este usuario solicitó un restablecimiento de contraseña.'];
        //             }
                  
        //        }else{
        //            //Retornamos el error: 
        //            return ['Login' => false, 'Error' => 'No existe ese usuario en el sistema.'];
        //        }
        //         break;

        //     case $restorePassword: 

        //         //Si existe, extraemos su estado de sesion actual: 
        //         if($validateUser['Query']){

        //             $client = new ClassUsuario(
        //                 password: $request->input(key: 'newPassword'),
        //                 confirmPassword: $request->input(key: 'confirmPassword')
        //             );

        //             // $response = $client->restorePassword(
        //             //     url: $request->input(key: 'url'),
        //             //     user: $validateUser['User']['email'],
        //             //     updated_at: $validateUser['User']['updated_at'],
        //             //     sessionStatus: $validateUser['User']['sesion'],
        //             //     newPassword: $request->input(key: 'newPassword')
        //             // );

        //             //Estado de sesion: 
        //             //-----------------
        //             //Sesion inactiva: 
        //             static $inactive = 'Inactiva';
        //             //Sesion activa: 
        //             static $active   = 'Activa';
        //             //Sesion pendiente: 
        //             static $pending  = 'Pendiente';

        //             if ($validateUser['User']['sesion'] == $inactive) {

        //                 if ($response) {

        //                     try {

        //                         //Realizamos la actualizacion del estado de la sesion: 
        //                         $usersController->updateSession(email: $request->input(key: 'email'),
        //                                                         session: $pending);
        //                         //Retornamos la respuesta: 
        //                         return $response;
        //                     } catch (Exception $e) {
        //                         //Retornamos el error: 
        //                         return ['restorePassword' => false, 'Error' => $e->getMessage()];
        //                     }
        //                 } else {
        //                     //Retornamos el error:
        //                     return $response;
        //                 }
        //             } elseif ($validateUser['User']['sesion'] == $pending) {

        //                 if ($response['restorePassword']) {

        //                     try {

        //                         //Realizamos la actualizacion del estado de la sesion: 
        //                         $usersController->restorePassword(email: $request->input(key: 'email'),
        //                                                           session: $inactive, 
        //                                                           newPassword: $response['newPassword']);
        //                         //Retornamos la respuesta: 
        //                         return $response;
        //                     } catch (Exception $e) {
        //                         //Retornamos el error: 
        //                         return ['restorePassword' => false, 'Error' => $e->getMessage()];
        //                     }
        //                 } else {

        //                     try {

        //                         //Realizamos la actualizacion del estado de la sesion: 
        //                         $usersController->updateSession(email: $request->input(key: 'email'),
        //                                                         session: $inactive);
        //                         //Retornamos el error: 
        //                         return $response;
        //                     } catch (Exception $e) {
        //                         //Retornamos el error: 
        //                         return ['restorePassword' => false, 'Error' => $e->getMessage()];
        //                     }
        //                 }
        //             } else {
        //                 //Retornamos el error:
        //                 return $response;
        //             }
        //         }else{
        //             //Retornamos el error: 
        //             return ['Login' => false, 'Error' => 'No existe ese usuario en el sistema.'];
        //         }
        //         break;

        //     case $closeLogin: 

        //         $model = Usuario::where('email', $request->input(key: 'email'));

        //         //Validamos que el usuario exista en la DB: 
        //         $validate = $model->first();

        //         if ($validate) {

        //              //Estado de sesion: 
        //             //-----------------
        //             //Sesion activa: 
        //             static $active   = 'Activa';
        //             //Sesion inactiva: 
        //             static $inactive = 'Inactiva';      

        //             if ($validate['sesion'] == $active) {

        //                 try {

        //                     //Realizamos la actualizacion del estado de la sesion: 
        //                     $usersController->updateSession(email: $request->input(key: 'email'),
        //                                                     session: $inactive);
        //                     //Retornamos la respuesta: 
        //                     return ['closeLogin' => true];
        //                 } catch (Exception $e) {
        //                     //Retornamos el error: 
        //                     return ['closeLogin' => false, 'Error' => $e->getMessage()];
        //                 }
        //             } else {
        //                 //Retornamos el error: 
        //                 return ['closeLogin' => false, 'Error' => 'El cliente no ha iniciado sesion en el sistema.'];
        //             }
        //         } else {
        //             //Retornamos el error: 
        //             return ['closeLogin' => false, 'Error' => 'No existe en el sistema.'];
        //         }
        //         break;

        //         default:
        //         return ['Error' => 'Formulario no valido.'];
        //         break;
        // }
    }
}
