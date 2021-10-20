<?php

namespace App\Http\Controllers\admin_module;

use App\Http\Controllers\Controller;
use App\Models\ServiceSpeciality;
use Exception;
use Illuminate\Http\Request;

class ServiceSpecialityController extends Controller
{
    // Metodo para retornar todos las especialidades de los servicios: 
    public function index()
    {
        // 
    }

    // Metodo para registrar una especialidad a un servicio especifico: 
    public function store(Request $request)
    {
        // Si los argumentos contienen caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar:
        $service_name    = strtolower($request->input('service_name'));
        $speciality_name = strtolower($request->input('speciality_name'));

        // Validamos que los argumentos no esten vacios:
        if(!empty('service_name')
        && !empty('speciality_name')){

            // Instanciamos los controladores de los modelos 'Service' y 'Speciality'. Para validar que existan: 
            $serviceController    = new ServiceController;
            $specialityController = new SpecialityController;

            // Validamos que existan: 
            $validateService    = $serviceController->show(service: $service_name);
            $validateSpeciality = $specialityController->show(speciality: $speciality_name);

            // Extraemos el contenido de las respuestas de validacion: 
            $contentValidateService    = $validateService->getOriginalContent();
            $contentValidateSpeciality = $validateSpeciality->getOriginalContent();

            // Si existen, extraemos sus 'id': 
            if($contentValidateService['query']){

                if($contentValidateSpeciality['query']){

                    // Extraemos los id: 
                    $service_id     = $contentValidateService['service']['id'];
                    $speciality_id  = $contentValidateSpeciality['speciality']['id'];

                    // Realizamos la consulta a la tabla de la DB:
                    $model = ServiceSpeciality::where('service_id', $service_id)->where('speciality_id', $speciality_id);

                    // Validamos que no exista el registro en la tabla de la DB:
                    $validateServiceSpeciality = $model->first();

                    // Sino existe, lo registramos: 
                    if(!$validateServiceSpeciality){

                        try{

                            ServiceSpeciality::create([
                                'service_id'    => $service_id,
                                'speciality_id' => $speciality_id
                            ]);

                            // Retornamos la respuesta:
                            return response(content: ['register' => true], status: 201);

                        }catch(Exception $e){
                            // Retornamos el error:
                            return ['register' => false, 'error' => $e->getMessage()];
                        }

                    }else{
                        // Retornamos el error:
                        return response(content: ['register' => false, 'error' => 'Ya existe esa especialidad para ese servicio.'], status: 403);
                    }

                }else{
                    // Retornamos el error:
                    return response(content: ['register' => false, 'error' => $contentValidateSpeciality['error']], status: 404);
                }

            }else{
                // Retornamos el error:
                return response(content: ['register' => false, 'error' => $contentValidateService['error']], status: 404);
            }


        }else{
            // Retornamos el error:
            return response(content: ['register' => false, 'error' => "Campo 'service_name' o 'speciality_name': NO deben estar vacios."], status: 403);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
