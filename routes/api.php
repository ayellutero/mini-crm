<?php

use Illuminate\Http\Request;

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

Route::namespace('API')->group(function() {
    Route::get('companies', 'CompaniesController@index');
    Route::get('companies_dt', 'CompaniesController@getData');

    Route::get('employees', 'EmployeesController@index');
    Route::get('employees_dt', 'EmployeesController@getData');

    
}); 