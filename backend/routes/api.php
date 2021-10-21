<?php

use App\Http\Controllers\admin_module\NurseSpecialityController;
use App\Http\Controllers\admin_module\PatientSpecialityController;
use App\Http\Controllers\admin_module\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Modulo de administrador: 
Route::apiResource(name: '/patients/v1', controller: 'App\Http\Controllers\admin_module\PatientController');

Route::apiResource(name: '/specialities/v1', controller: 'App\Http\Controllers\admin_module\SpecialityController');

Route::apiResource(name: '/patient-specialities/v1', controller: 'App\Http\Controllers\admin_module\PatientSpecialityController');
Route::delete(uri: '/delete-patient-specialities/v1/{patient}/{speciality}', action: [PatientSpecialityController::class, 'destroy']);

Route::apiResource(name: '/nurses/v1', controller: 'App\Http\Controllers\admin_module\NurseController');

Route::apiResource(name: '/roles/v1', controller: 'App\Http\Controllers\admin_module\RoleController');
<<<<<<< HEAD
Route::get(uri: '/nurses-role/v1/{role}', action: [RoleController::class, 'nurses']);

Route::apiResource(name: '/nurse-specialities/v1', controller: 'App\Http\Controllers\admin_module\NurseSpecialityController');
Route::delete(uri: '/delete-nurse-specialities/v1/{identification}/{speciality}', action: [NurseSpecialityController::class, 'destroy']);
=======
Route::get(uri: '/professionals-role/v1/{role}', action: [RoleController::class, 'professionals']);

Route::apiResource(name: '/nurse-specialities/v1', controller: 'App\Http\Controllers\admin_module\NurseSpecialityController');
Route::delete(uri: '/delete-nurse-specialities/v1/{identification}/{speciality}', action: [NurseSpecialityController::class, 'destroy']);
>>>>>>> frontend
