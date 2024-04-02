<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function () {
    Route::get('/verificar-conexion', function () {
        $url = 'https://www.ejemplo.com';
        $connected = @file_get_contents($url);
      
        
        if ($connected) {
            return response()->json(['message' => 'Conexión exitosa'], 200);
        } else {
            return response()->json(['message' => 'No se pudo conectar'], 400);
        }
    });
});


