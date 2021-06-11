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

Route::get('/', function () {
    return "Mericologos API";
    // return view('test');
});

Route::namespace('App\Http\Controllers\Api')->group(function (){

    Route::post('/dateFilter','DateController@indexFilter')->name('date.index')->middleware(['auth:api','role_or_permission:admin|date.index']);
    Route::post('/date','DateController@store')->name('date.store')->middleware(['auth:api','role_or_permission:admin|date.store']);
    Route::post('/lockDate','DateController@lockDates')->name('date.lock')->middleware(['auth:api','role_or_permission:admin|date.lock']);
    Route::get('/date','DateController@index');

    Route::post('/paypal/link/{sale}','DateController@paymentPaypal');
    Route::post('/stripe/link/{sale}','DateController@paymentStripe');

    Route::post('/login','PassportController@login')->name('login');
    Route::post('/register','PassportController@store')->name('registerAdmin')->middleware(['auth:api','role_or_permission:admin|admin.store']);
    Route::post('/registerDoctor','PassportController@storeDoctor')->name('registerDoctor')->middleware(['auth:api','role_or_permission:admin|doctor.store']);
    Route::post('/registerPatient','PassportController@storePatient')->name('registerPatient')->middleware(['auth:api','role_or_permission:admin|patient.store']);
    Route::put('/users/{user}','UserController@updateUser')->name('updateUser')->middleware(['auth:api','role_or_permission:admin|users.update']);
    Route::get('/users/{user}','UserController@show')->name('showUser')->middleware(['auth:api','role_or_permission:admin|users.show']);
    Route::get('/userDates/{user}','UserController@userDates')->name('patientDates');

    Route::get('/doctors','UserController@doctors')->name('indexDoctors')->middleware(['auth:api','role_or_permission:admin|doctors.index']);
    Route::get('/patients','UserController@patients')->name('indexPatients')->middleware(['auth:api','role_or_permission:admin|patients.index']);
    Route::get('/admins','UserController@admins')->name('indexAdmins')->middleware(['auth:api','role_or_permission:admin|admins.index']);
    Route::get('/medicalHistory','UserController@medicalHistory')->name('medicalHistory.all')->middleware(['auth:api','role_or_permission:admin|medicalHistory.all']);
    Route::get('/medicalHistory/{user}','UserController@medicalHistoryByUser')->name('medicalHistory.byUser')->middleware(['auth:api','role_or_permission:admin|medicalHistory.byUser']);

    // Route::get('/configurations','SpecialtyController@index')->name('configurations.index')->middleware(['auth:api','role_or_permission:admin|configurations.index']);
    // Route::get('/configurations/{configuration}','SpecialtyController@show')->name('configurations.show')->middleware(['auth:api','role_or_permission:admin|configurations.index']);
    // Route::put('/configurations/{configuration}','SpecialtyController@update')->name('configurations.update')->middleware(['auth:api','role_or_permission:admin|configurations.update']);
    Route::get('/configurations','ConfigurationController@index');
    Route::put('/configurations','ConfigurationController@update');

    Route::post('/patientsByStatus','UserController@patientsByStatus');

    Route::get('/branchOffices','BranchOfficeController@index')->name('branch_offices.index')->middleware(['auth:api','role_or_permission:admin|branch_offices.index']);
    Route::post('/branchOffices','BranchOfficeController@store')->name('branch_offices.store')->middleware(['auth:api','role_or_permission:admin|branch_offices.store']);
    Route::get('/branchOffices/{branchOffice}','BranchOfficeController@show')->name('branch_offices.index')->middleware(['auth:api','role_or_permission:admin|branch_offices.index']);
    Route::get('/branchOfficesPaginate','BranchOfficeController@indexPaginate')->name('branch_offices.indexPaginate')->middleware(['auth:api','role_or_permission:global_admin|branch_offices.index']);
    Route::put('/branchOffices/{branchOffice}','BranchOfficeController@update')->name('branch_offices.update')->middleware(['auth:api','role_or_permission:admin|branch_offices.update']);
    Route::delete('/branchOffices/{branchOffice}','BranchOfficeController@destroy')->name('branch_offices.destroy')->middleware(['auth:api','role_or_permission:admin|branch_offices.destroy']);
    
    
    Route::get('/shift','ShiftController@index')->name('date.index')->middleware(['auth:api','role_or_permission:admin|date.index']);

    Route::post('/setAbsence/{datesInfo}','DateController@setAbsence')->name('date.absence')->middleware(['auth:api','role_or_permission:admin|date.absence']);
    Route::get('/paypal/status/{saleInfo}', 'DateController@payPalStatus');
    Route::get('/paypal/status', 'PaymentController@payPalStatus');


    Route::get('/reportDates/{id}','ReportController@reportsDates');
    Route::get('/gains','ReportController@gains');

    Route::get('/sales','SaleController@index');

    Route::get('/services','ServiceController@index');
    Route::post('/services','ServiceController@store');
    Route::get('/services/{service}','ServiceController@show');
    Route::put('/services/{service}','ServiceController@update');
    Route::delete('/services/{service}','ServiceController@destroy');

    Route::get('/specialties','SpecialtyController@index')->name('specialties.index')->middleware(['auth:api','role_or_permission:admin|specialties.index']);
    Route::post('/specialties','SpecialtyController@store')->name('specialties.store')->middleware(['auth:api','role_or_permission:admin|specialties.store']);
    Route::get('/specialties/{specialty}','SpecialtyController@show')->name('specialties.index')->middleware(['auth:api','role_or_permission:admin|specialties.index']);
    Route::put('/specialties/{specialty}','SpecialtyController@update')->name('specialties.update')->middleware(['auth:api','role_or_permission:admin|specialties.update']);
    Route::delete('/specialties/{specialty}','SpecialtyController@destroy')->name('specialties.destroy')->middleware(['auth:api','role_or_permission:admin|specialties.destroy']);

    Route::post('/addSpecialtiesToDoctor','SpecialtyController@addSpecialtiesToDoctor');
    Route::post('/removeSpecialtiesToDoctor','SpecialtyController@removeSpecialtiesToDoctor');

    Route::post('/authUserInfo','PassportController@authUserInfo')->name('authUserInfo')->middleware('auth:api');
    Route::post('/test','PassportController@test')->name('test')->middleware(['auth:api','role_or_permission:admin|testpermissions']);
});


