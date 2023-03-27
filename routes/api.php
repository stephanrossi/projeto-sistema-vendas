<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('login')->group(function () {
    Route::post('/', [UserController::class, 'loginUser']);
});

Route::middleware('auth:sanctum')
    ->prefix('addresses')
    ->group(function () {
        Route::get('/', [AddressesController::class, 'getAddress']);
    });

Route::middleware('auth:sanctum')
    ->prefix('client')
    ->group(function () {
        Route::get('/', [ClientsController::class, 'listClients']);
        Route::get('/find', [ClientsController::class, 'findClient']);
        Route::get('/{id}', [ClientsController::class, 'getClient']);
        Route::post('/{id}', [ClientsController::class, 'editClient']);
    });

Route::middleware('auth:sanctum')
    ->prefix('user')
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
    });
