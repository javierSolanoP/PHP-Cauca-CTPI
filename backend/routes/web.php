<?php

use App\Http\Controllers\public_module\OrganizationChartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(uri: '/stream-organization_chart', action: [OrganizationChartController::class, 'stream']);
Route::get(uri: '/download-organization_chart', action: [OrganizationChartController::class, 'download']);
Route::get(uri: '/qr-organization_chart', action: [OrganizationChartController::class, 'qrCode']);