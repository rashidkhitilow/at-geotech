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
Route::post('login', [App\Http\Controllers\ApiController::class, 'login']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', [App\Http\Controllers\ApiController::class, 'logout']);
    Route::get('user', [App\Http\Controllers\ApiController::class, 'getAuthUser']);
    Route::prefix('v1')->group(function () {
        Route::prefix('employee_datas')->group(function () {
            Route::get('/list', [App\Http\Controllers\EmployeeDataController::class, 'list']);
            Route::post('/add', [App\Http\Controllers\EmployeeDataController::class, 'add'])->middleware('checkFieldName');
            Route::post('/update/{id}', [App\Http\Controllers\EmployeeDataController::class, 'update'])->middleware('checkFieldName');
            Route::post('/delete/{id}', [App\Http\Controllers\EmployeeDataController::class, 'delete']);
        });
    });
});
