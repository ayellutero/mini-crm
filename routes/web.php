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

Route::group(['prefix' => 'e'], function() {
    Route::namespace('Auth')->name('e.')->group(function() {
        Route::get('home', 'EmployeeHomeController@index')->name('home');
        Route::get('login', 'EmployeeLoginController@showLoginForm')->name('login');
        Route::post('login', 'EmployeeLoginController@login')->name('login');
        Route::get('logout', 'EmployeeLoginController@logout')->name('logout');    
    });

    Route::group(['middleware' => 'auth:employee'], function() {
        // allow only index page and view (modal)
        Route::resource('companies', 'CompaniesController', ['as' => 'e'])->only([
            'index', 'show'
        ]);

        // allow only index page and view (modal)
        Route::resource('employees', 'EmployeesController', ['as' => 'e'])->only([
            'index', 'show'
        ]);
        
        Route::resource('emails', 'EmailsController', ['as' => 'e'])->only([
            'create'
        ]);
        
        Route::get('export_employees', 'EmployeesController@export')->name('e.employees.export');
        Route::post('/emails/send', 'EmailsController@send')->name('e.emails.send');
    });
});

Route::group(['middleware' => 'auth'], function() {
    Route::resources([
        'companies' => 'CompaniesController',
        'employees' => 'EmployeesController',
    ]);
    Route::get('export_employees', 'EmployeesController@export')->name('employees.export');

    Route::resource('emails', 'EmailsController')->only([
        'create'
    ]);

    Route::post('/emails/send', 'EmailsController@send')->name('emails.send');

});

Route::get('/emails', function () {
    return view('emails.template');
});