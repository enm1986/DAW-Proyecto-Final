<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/comunidad/{id}', 'BoardController@index');

Route::group(['middleware' => 'checkAdmin'], function() {
    Route::get('/comunidad/{id}/admin', 'BoardController@admin');
    Route::get('/comunidad/{id}/datos', 'BoardController@datos');
    Route::get('/comunidad/{id}/propiedades', 'BoardController@propiedades');
    Route::get('/comunidad/{id}/propietarios', 'BoardController@propietarios');
    Route::get('/comunidad/{id}/asignar', 'BoardController@asignar');
    Route::get('/comunidad/{id}/proveedores', 'BoardController@proveedores');
    Route::get('/comunidad/{id}/fondos', 'BoardController@fondos');
    Route::get('/comunidad/{id}/cuentas', 'BoardController@cuentas');
    Route::get('/comunidad/{id}/gastos', 'BoardController@gastos');
    Route::get('/comunidad/{id}/ingresos', 'BoardController@ingresos');
    Route::get('/comunidad/{id}/cuotas', 'BoardController@cuotas');
});
