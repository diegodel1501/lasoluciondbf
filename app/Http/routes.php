<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::resource(
'categoria','CategoriaController'
);
Route::resource(
'producto','ProductoController'
);
Route::resource(
'insumo','InsumoController'
);
Route::resource(
'cliente','ClienteController'
);
Route::resource(
'pedido','PedidoController'
);
Route::resource(
'empleado','EmpleadoController'
);
Route::post(
'insumo.add','InsumoController@add'
);
Route::auth();

Route::get('/home', 'HomeController@index');

//Reportes
Route::get('/vendedores', 'ReporteController@vendedores');
Route::get('/panaderos', 'ReporteController@panaderos');
Route::get('/clientes', 'ReporteController@clientes');
Route::get('/estadisticas', 'ReporteController@estadisticas');



