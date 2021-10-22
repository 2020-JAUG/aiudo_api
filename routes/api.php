<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\HistorialDePagoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UserController;
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

//Ruta visibles sin authenticate para los nuevos registros.
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


//Aquí se indican las rutas que requieren authenticate.
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Users.
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/all_users', [UserController::class, 'index']);
    Route::get('/search/{name}', [UserController::class, 'search']);//Búsqueda por coincidencias de letras.
    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('user/edit/{id}', [UserController::class, 'update']);

    //Cuentas.
    Route::post('/createaccount', [CuentaController::class, 'create']);
    Route::post('/allaccounts', [CuentaController::class, 'index']);
    Route::get('/useraccount', [CuentaController::class, 'show']);

    //Préstamos.
    Route::post('/newloan', [PrestamoController::class, 'create']);
    Route::post('/allloans', [PrestamoController::class, 'index']);
    Route::get('/userloan', [PrestamoController::class, 'show']);

    //Historial de pagos.
    Route::post('/paymenthistory', [HistorialDePagoController::class, 'create']);
    Route::post('/allpayments', [HistorialDePagoController::class, 'index']);
    Route::get('/userpayments', [HistorialDePagoController::class, 'show']);
});
