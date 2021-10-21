<?php

use App\Http\Controllers\PassportAuthController;
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

//Ruta visibles sin auth para los nuevos registros.
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::get('logout', [PassportAuthController::class, 'logout']);

//Aquí se indican las rutas que requieren authenticate.
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    //Crud del user.
    Route::resource('users', UserController::class);
    //Logout
    Route::post('user/logout', [UserController::class, 'logout']);
});
