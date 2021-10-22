<?php

namespace App\Http\Controllers\public_module;

use App\Http\Controllers\admin_module\NurseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\Class\Nurse;
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

        //Instanciamos el controlador del modelo 'Nurse'. Para validar la existencia de la enfermera y actualizar sus estados de sesion y contrasenia: 
        $nursesController = new NurseController;

        // Validamos que exista la enfermera: 
        $validateNurse = $nursesController->login(email: $request->input('email'));

        // Si existe, recibimos la peticion correspondiente: 
        if($validateNurse['query']){

            switch($form){

                case $login: 

                    //Estado de sesion: 
                    //-----------------
                    //Sesion inactiva: 
                    static $inactive = 'Inactiva';
                    //Sesion activa: 
                    static $active   = 'Activa';
                    //Sesion pendiente: 
                    static $pending  = 'Pendiente';

                    if($validateNurse['nurse']->session == $inactive){

                        //Realizamos la actualizacion del estado de la sesion: 
                        $nursesController->updateSession(email: $request->input(key: 'email'),
                                                                session: $active);

                        //Realizamos una nueva consulta al controlador de 'Usuarios', para cargar el nuevo estado de sesion: 
                        $nurse = $nursesController->login(email: $request->input(key: 'email'));
                        
                        //Retornamos la respuesta: 
                        return response(content: ['login' => true, 'nurse' => $nurse['nurse']], status: 200);

                    }elseif($validateNurse['nurse']->session == $active){
                        //Retornamos el error: 
                        return response(content: ['login' => false, 'Error' => 'Esta enfermera ya inicio sesion en el sistema.'], status: 403);
                                
                    }elseif($validateNurse['nurse']->session == $pending){
                        //Retornamos el error: 
                        return response(content: ['login' => false, 'Error' => 'Esta enfermera solicitó un restablecimiento de contraseña.'], status: 403);
                    }

                    break;

                    case $restorePassword: 

                        //Si existe, extraemos su estado de sesion actual: 
                        if($validateNurse['query']){
                
                            //Estado de sesion: 
                            //-----------------
                            //Sesion inactiva: 
                            static $inactive = 'Inactiva';
                            //Sesion activa: 
                            static $active   = 'Activa';
                            //Sesion pendiente: 
                            static $pending  = 'Pendiente';
                
                            if ($validateNurse['nurse']->session == $inactive) {
                
                                try {
                
                                    //Realizamos la actualizacion del estado de la sesion: 
                                    $response = $nursesController->updateSession(email: $request->input(key: 'email'),
                                                                                session: $pending);

                                    // Enviamos el correo de restablecimiento: 
                                    $email = $nursesController->restorePassword(url: 'https://www.google.com',
                                                                                email: $request->input(key: 'email'),
                                                                                updated_at: $validateNurse['nurse']->updated_at,
                                                                                sessionStatus: $inactive,
                                                                                newPassword: $request->input('password'));
                                    //Retornamos la respuesta: 
                                    return response(content: $email, status: 204);

                                } catch (Exception $e) {
                                    //Retornamos el error: 
                                    return response(content: ['restorePassword' => false, 'error' => $e->getMessage()], status: 500);
                                }
                                    
                            } elseif ($validateNurse['nurse']->session == $pending) {
                
                                try {

                                    //Realizamos la actualizacion del estado de la sesion: 
                                    $response = $nursesController->updateSession(email: $request->input(key: 'email'),
                                                                                session: $pending);
                
                                    //Realizamos la actualizacion del estado de la sesion: 
                                    $email = $nursesController->restorePassword(url: $request->input('url'),
                                                                                    email: $request->input(key: 'email'),
                                                                                    updated_at: $validateNurse['nurse']->updated_at,
                                                                                    sessionStatus: $pending, 
                                                                                    newPassword: $request->input('password'));
                                    //Retornamos la respuesta: 
                                    return response(content: $email, status: 200);

                                } catch (Exception $e) {
                                    //Retornamos el error: 
                                    return response(content: ['restorePassword' => false, 'error' => $e->getMessage()], status: 500);
                                }

                            } else {
                
                                try {
                
                                    //Realizamos la actualizacion del estado de la sesion: 
                                    $response = $nursesController->updateSession(email: $request->input(key: 'email'),
                                                                    session: $inactive);

                                    //Realizamos la actualizacion del estado de la sesion: 
                                    $email = $nursesController->restorePassword(url: $request->input('url'),
                                                                                email: $request->input(key: 'email'),
                                                                                updated_at: $validateNurse['nurse']->updated_at,
                                                                                sessionStatus: $active, 
                                                                                newPassword: $request->input('password'));

                                    //Retornamos la respuesta: 
                                    return response(content: $response, status: 204);

                                } catch (Exception $e) {
                                    //Retornamos el error: 
                                    return response(content: ['restorePassword' => false, 'error' => $e->getMessage()], status: 500);
                                }
                            }
                                    
                        }else{
                            //Retornamos el error: 
                            return response(content: ['restorePassword' => false, 'error' => 'No existe esa enfermera en el sistema.'], status: 404);
                        }
                        break;

                        case $closeLogin: 
                    
                            //Estado de sesion: 
                            //-----------------
                            //Sesion activa: 
                            static $active   = 'Activa';
                            //Sesion inactiva: 
                            static $inactive = 'Inactiva';      
                    
                            if ($validateNurse['nurse']->session == $active) {
                    
                                try {
                    
                                    //Realizamos la actualizacion del estado de la sesion: 
                                    $nursesController->updateSession(email: $request->input(key: 'email'),
                                                                    session: $inactive);

                                    //Retornamos la respuesta: 
                                    return response(content: ['closeLogin' => true], status: 204);

                                } catch (Exception $e) {
                                    //Retornamos el error: 
                                    return response(content:['closeLogin' => false, 'error' => $e->getMessage()], status: 500);
                                }

                            } else {
                                //Retornamos el error: 
                                return response(content: ['closeLogin' => false, 'error' => 'El cliente no ha iniciado sesion en el sistema.'], status: 403);
                            }

                            break;

                        default:
                                return response(content: ['error' => 'formulario no valido.'], status: 403);
                                break;
            }

        }else{
            // Retornamos el error:
            return response(content: ['login' => false, 'error' => $validateNurse['error']], status: 404);
        }
    }
}
