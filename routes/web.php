<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Auth::routes(['register' => false]);
Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});

Auth::routes();
// -----------------------------login-----------------------------------------
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
// ----------------------------- user userManagement ------------------------------
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/filter', [App\Http\Controllers\UserController::class, 'filter']);
    Route::post('/users/remove', [App\Http\Controllers\UserController::class, 'remove']);
    Route::post('/users/new', [App\Http\Controllers\UserController::class, 'new']);
    Route::post('/users/save', [App\Http\Controllers\UserController::class, 'save']);

    Route::get('/employee_datas', [App\Http\Controllers\EmployeeDataController::class, 'index']);
    Route::get('/employee_datas/filter', [App\Http\Controllers\EmployeeDataController::class, 'filter']);
    Route::post('/employee_datas/remove', [App\Http\Controllers\EmployeeDataController::class, 'remove']);
    Route::post('/employee_datas/new', [App\Http\Controllers\EmployeeDataController::class, 'new'])->middleware('checkFieldName');
    Route::post('/employee_datas/save', [App\Http\Controllers\EmployeeDataController::class, 'save'])->middleware('checkFieldName');


    Route::get('/autocomplete/departments', [App\Http\Controllers\DepartmentController::class, 'autocomplete']);
    Route::get('/autocomplete/positions', [App\Http\Controllers\PositionController::class, 'autocomplete']);
    Route::get('/autocomplete/roles', [App\Http\Controllers\RoleController::class, 'autocomplete']);
});