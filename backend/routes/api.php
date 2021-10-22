<?php

use App\Http\Controllers\admin_module\NurseSpecialityController;

use App\Http\Controllers\admin_module\RoleController;
use App\Http\Controllers\patient_module\PatientSpecialityController;
use App\Http\Controllers\shift_module\ShiftController;
use App\Http\Controllers\shift_module\TimeController;
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
Route::apiResource(name: '/specialities/v1', controller: 'App\Http\Controllers\admin_module\SpecialityController');

Route::apiResource(name: '/nurses/v1', controller: 'App\Http\Controllers\admin_module\NurseController');

Route::apiResource(name: '/roles/v1', controller: 'App\Http\Controllers\admin_module\RoleController');
Route::get(uri: '/nurses-role/v1/{role}', action: [RoleController::class, 'nurses']);

Route::apiResource(name: '/nurse-specialities/v1', controller: 'App\Http\Controllers\admin_module\NurseSpecialityController');
Route::delete(uri: '/delete-nurse-specialities/v1/{identification}/{speciality}', action: [NurseSpecialityController::class, 'destroy']);

// Modulo de pacientes: 
Route::apiResource(name: '/patients/v1', controller: 'App\Http\Controllers\patient_module\PatientController');

Route::apiResource(name: '/patient-specialities/v1', controller: 'App\Http\Controllers\patient_module\PatientSpecialityController');
Route::delete(uri: '/delete-patient-specialities/v1/{patient}/{speciality}', action: [PatientSpecialityController::class, 'destroy']);

// Modulo de turnos: 
Route::apiResource(name: '/times/v1', controller: 'App\Http\Controllers\shift_module\TimeController');
Route::get(uri: '/times/v1/{start_time}/{finish_time}', action : [TimeController::class, 'show']);
Route::delete(uri: '/times/v1/{start_time}/{finish_time}', action : [TimeController::class, 'destroy']);
Route::get(uri: '/shifts-schedules/v1', action: [ShiftController::class, 'shifts']);
Route::apiResource(name: '/shifts/v1', controller: 'App\Http\Controllers\shift_module\ShiftController');
//Route::apiResource(name: '/shifts-create/v1', controller: 'App\Http\Controllers\shift_module\ShiftController');

Route::apiResource(name: '/schedules/v1', controller: 'App\Http\Controllers\shift_module\ScheduleController');

Route::get(uri: '/module-assignment/v1', action: [ModulesRolesController::class, 'index']);
Route::apiResource(name: '/module-assignment/v1', controller: 'App\Http\Controllers\admin_module\ModulesRolesController');
Route::delete(uri: '/delete-module-assignment/v1/{roleName}/{moduleName}', action: [ModulesRolesController::class, 'destroy']);

// Modulo publico: 
Route::apiResource(name: '/login/v1', controller: 'App\Http\Controllers\public_module\LoginController');
