<?php

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
Route::apiResource(name: '/modules/v1', controller: 'App\Http\Controllers\admin_module\ModuleController');
