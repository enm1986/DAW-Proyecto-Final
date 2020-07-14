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
    Route::post('acceso', 'API\LoginAccesoController@create');


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

        Route::get('comunidad/{id}/proveedores', 'API\ProveedoresController@index');
        Route::post('comunidad/{id}/proveedores', 'API\ProveedoresController@create');
        Route::put('comunidad/{id}/proveedores/{proveedor}', 'API\ProveedoresController@update');
        Route::delete('comunidad/{id}/proveedores/{proveedor}', 'API\ProveedoresController@delete');

        Route::get('comunidad/{id}/fondos', 'API\ContFondosController@index');
        Route::post('comunidad/{id}/fondos', 'API\ContFondosController@create');
        Route::put('comunidad/{id}/fondos/{fondo}', 'API\ContFondosController@update');
        Route::delete('comunidad/{id}/fondos/{fondo}', 'API\ContFondosController@delete');

        Route::get('comunidad/{id}/cuentas', 'API\ContCuentasController@index');
        Route::post('comunidad/{id}/cuentas', 'API\ContCuentasController@create');
        Route::put('comunidad/{id}/cuentas/{cuenta}', 'API\ContCuentasController@update');
        Route::delete('comunidad/{id}/cuentas/{cuenta}', 'API\ContCuentasController@delete');

        Route::get('comunidad/{id}/gastos', 'API\ContGastosController@index');
        Route::post('comunidad/{id}/gastos', 'API\ContGastosController@create');
        Route::put('comunidad/{id}/gastos/{gasto}', 'API\ContGastosController@update');
        Route::delete('comunidad/{id}/gastos/{gasto}', 'API\ContGastosController@delete');

        Route::get('comunidad/{id}/ingresos', 'API\ContIngresosController@index');
        Route::post('comunidad/{id}/ingresos', 'API\ContIngresosController@create');
        Route::put('comunidad/{id}/ingresos/{ingreso}', 'API\ContIngresosController@update');
        Route::delete('comunidad/{id}/ingresos/{ingreso}', 'API\ContIngresosController@delete');

        Route::get('comunidad/{id}/cuotas', 'API\ContCuotasController@index');
        Route::post('comunidad/{id}/cuotas', 'API\ContCuotasController@create');
        Route::put('comunidad/{id}/cuotas/{cuota}', 'API\ContCuotasController@update');
        Route::delete('comunidad/{id}/cuotas/{cuota}', 'API\ContCuotasController@delete');
    });
});
