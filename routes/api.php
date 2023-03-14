<?php

use App\Http\Controllers\User\TransactionDetailsController;
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


Route::get('test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API test route is working'
    ], 200);
});


Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::apiResource('transaction', TransactionDetailsController::class);
