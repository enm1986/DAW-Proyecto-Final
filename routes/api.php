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
    Route::get('propiedades/{id}', 'API\PropiedadesController@indexUser');

    Route::get('comunidad/{id}', 'API\ComunidadesController@show');
    Route::post('comunidad', 'API\ComunidadesController@create');


    //ADMIN
    Route::group(['middleware' => 'checkAdmin'], function() {
        Route::put('comunidad/{id}', 'API\ComunidadesController@update');
        Route::delete('comunidad/{id}', 'API\ComunidadesController@delete');

        Route::get('comunidad/{id}/propiedades', 'API\PropiedadesController@indexAll');
        Route::get('comunidad/{id}/propiedades/tipos', 'API\PropiedadesController@tipos');
        Route::post('comunidad/{id}/propiedades', 'API\PropiedadesController@create');
        Route::put('comunidad/{id}/propiedades/{propiedad}', 'API\PropiedadesController@update');
        Route::delete('comunidad/{id}/propiedades/{propiedad}', 'API\PropiedadesController@delete');
        
        Route::get('comunidad/{id}/propietarios', 'API\PropietariosController@index');
        Route::post('comunidad/{id}/propietarios', 'API\PropietariosController@create');
        Route::put('comunidad/{id}/propietarios/{propietario}', 'API\PropietariosController@update');
        Route::delete('comunidad/{id}/propietarios/{propietario}', 'API\PropietariosController@delete');
        
        Route::get('comunidad/{id}/asignar', 'API\PropPropController@index');
        Route::post('comunidad/{id}/asignar', 'API\PropPropController@create');
        Route::delete('comunidad/{id}/asignar', 'API\PropPropController@delete');
    });



    
    
    
    
});
