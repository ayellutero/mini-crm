<?php

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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Auth')->name('e.')->prefix('e')->group(function() {
    Route::get('home', 'EmployeeHomeController@index')->name('home');
    Route::get('login', 'EmployeeLoginController@showLoginForm')->name('login');
    Route::post('login', 'EmployeeLoginController@login')->name('login');
    Route::get('logout', 'EmployeeLoginController@logout')->name('logout');
});

Route::resources([
    'companies' => 'CompaniesController',
    'employees' => 'EmployeesController',
]);

Route::get('export_employees', 'EmployeesController@export')->name('employees.export');