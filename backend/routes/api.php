<?php

use App\Http\Controllers\admin_module\ProfessionalSpecialityController;
use App\Http\Controllers\admin_module\RoleController;
use App\Http\Controllers\admin_module\ServiceSpecialityController;
use Illuminate\Http\Request;
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
Route::apiResource(name: '/services/v1', controller: 'App\Http\Controllers\admin_module\ServiceController');

Route::apiResource(name: '/specialities/v1', controller: 'App\Http\Controllers\admin_module\SpecialityController');

Route::apiResource(name: '/service-specialities/v1', controller: 'App\Http\Controllers\admin_module\ServiceSpecialityController');
Route::delete(uri: '/delete-service-specialities/v1/{service}/{speciality}', action: [ServiceSpecialityController::class, 'destroy']);

Route::apiResource(name: '/professionals/v1', controller: 'App\Http\Controllers\admin_module\ProfessionalController');

Route::apiResource(name: '/roles/v1', controller: 'App\Http\Controllers\admin_module\RoleController');
Route::get(uri: '/professionals-role/v1/{role}', action: [RoleController::class, 'professionals']);

Route::apiResource(name: '/professional-specialities/v1', controller: 'App\Http\Controllers\admin_module\ProfessionalSpecialityController');
Route::delete(uri: '/delete-professional-specialities/v1/{identification}/{speciality}', action: [ProfessionalSpecialityController::class, 'destroy']);