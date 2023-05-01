<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ManufacturersController;
use App\Http\Controllers\ProductsController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum', 'verified')
    ->prefix('addresses')
    ->group(function () {
        Route::get('/', [AddressesController::class, 'index']);
        Route::get('/find', [AddressesController::class, 'show']);
        Route::post('/', [AddressesController::class, 'store']);
    });

Route::middleware('auth:sanctum', 'verified')
    ->prefix('client')
    ->group(function () {
        Route::get('/', [ClientsController::class, 'index']);
        Route::post('/', [ClientsController::class, 'store']);
        Route::get('/find', [ClientsController::class, 'show']);
        Route::put('/{id}', [ClientsController::class, 'update']);
        Route::delete('/{id}', [ClientsController::class, 'destroy']);
    });

Route::middleware('auth:sanctum', 'verified')
    ->prefix('product')
    ->group(function () {
        Route::get('/', [ProductsController::class, 'index']);
        Route::post('/', [ProductsController::class, 'store']);
        Route::put('/{id}', [ProductsController::class, 'update']);
        Route::get('/{id}', [ProductsController::class, 'show']);
    });

Route::middleware('auth:sanctum', 'verified')
    ->prefix('manufacturer')
    ->group(function () {
        Route::get('/', [ManufacturersController::class, 'index']);
        Route::post('/', [ManufacturersController::class, 'store']);
        Route::put('/{id}', [ManufacturersController::class, 'update']);
        Route::get('/{id}', [ManufacturersController::class, 'show']);
        Route::delete('/{id}', [ManufacturersController::class, 'destroy']);
    });

Route::middleware('auth:sanctum', 'verified')
    ->prefix('user')
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
    });
