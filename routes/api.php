<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\TransactionController;
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

Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::get('/v1/@me', [AuthController::class, 'me'])->middleware('auth:api');

Route::group([
    'middleware' => ['sec.token'],
    'prefix' => 'v1',
], function () {
    Route::post('/order', [OrderController::class, 'order']);
    Route::post('/payment', [OrderController::class, 'payment']);
    Route::get('/status', [OrderController::class, 'status']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/transactions', [TransactionController::class, 'index']);
});
