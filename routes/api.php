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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace('App\Http\Controllers\Api')->group(function (){
    Route::post('/login','PassportController@login')->name('login');
    Route::post('/register','PassportController@store')->name('registerAdmin')->middleware(['auth:api','role_or_permission:admin|admin.store']);
    Route::post('/registerDoctor','PassportController@storeDoctor')->name('registerDoctor')->middleware(['auth:api','role_or_permission:admin|doctor.store']);
    Route::post('/registerPatient','PassportController@storePatient')->name('registerPatient')->middleware(['auth:api','role_or_permission:admin|patient.store']);
    Route::put('/users/{user}','UserController@updateUser')->name('updateUser')->middleware(['auth:api','role_or_permission:admin|users.update']);
    Route::get('/users/{user}','UserController@show')->name('showUser')->middleware(['auth:api','role_or_permission:admin|users.show']);
    
    Route::get('/doctors','UserController@doctors')->name('indexDoctors')->middleware(['auth:api','role_or_permission:admin|doctors.index']);
    Route::get('/patients','UserController@patients')->name('indexPatients')->middleware(['auth:api','role_or_permission:admin|patients.index']);
    Route::get('/admins','UserController@admins')->name('indexAdmins')->middleware(['auth:api','role_or_permission:admin|admins.index']);

    Route::get('/branchOffices','BranchOfficeController@index')->name('branch_offices.index')->middleware(['auth:api','role_or_permission:admin|branch_offices.index']);
    Route::post('/branchOffices','BranchOfficeController@store')->name('branch_offices.store')->middleware(['auth:api','role_or_permission:admin|branch_offices.store']);
    Route::get('/branchOffices/{branchOffice}','BranchOfficeController@show')->name('branch_offices.index')->middleware(['auth:api','role_or_permission:admin|branch_offices.index']);
    Route::get('/branchOfficesPaginate','BranchOfficeController@indexPaginate')->name('branch_offices.indexPaginate')->middleware(['auth:api','role_or_permission:global_admin|branch_offices.index']);
    Route::put('/branchOffices/{branchOffice}','BranchOfficeController@update')->name('branch_offices.update')->middleware(['auth:api','role_or_permission:admin|branch_offices.update']);
    Route::delete('/branchOffices/{branchOffice}','BranchOfficeController@destroy')->name('branch_offices.destroy')->middleware(['auth:api','role_or_permission:admin|branch_offices.destroy']);

    Route::post('/authUserInfo','PassportController@authUserInfo')->name('authUserInfo')->middleware('auth:api');
    Route::post('/test','PassportController@test')->name('test')->middleware(['auth:api','role_or_permission:admin|testpermissions']);
});


