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

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('comunidades', 'API\ComunidadesController@index');
    Route::get('propiedades/{id}', 'API\PropiedadesController@index');

    //ADMIN
    Route::get('comunidad/{id}', 'API\ComunidadesController@show');
    Route::post('comunidad', 'API\ComunidadesController@create');
    Route::put('comunidad/{id}', 'API\ComunidadesController@update');
    Route::delete('comunidad/{id}', 'API\ComunidadesController@delete');

    Route::get('comunidad/propiedades/tipos', 'API\PropiedadesController@tipos');
    Route::get('comunidad/{id}/propiedades', 'API\PropiedadesController@indexAdmin');
    Route::post('comunidad/propiedades', 'API\PropiedadesController@create');
    Route::put('comunidad/propiedades/{id}', 'API\PropiedadesController@update');
    Route::delete('comunidad/propiedades/{id}', 'API\PropiedadesController@delete');

    Route::get('comunidad/{id}/propietarios', 'API\PropietariosController@index');
    Route::post('comunidad/propietarios', 'API\PropietariosController@create');
    Route::put('comunidad/propietarios/{id}', 'API\PropietariosController@update');
    Route::delete('comunidad/propietarios/{id}', 'API\PropietariosController@delete');
});
