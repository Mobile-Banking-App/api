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


Route::get('test', function () {
    return response()->json([
        'status' => true,
        'message' => 'user test route is working'
    ], 200);
});


Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');



// A U T H E N T I C A T E D     R O U T E S
Route::middleware(['auth:user-api', 'scopes:user'])->group(function () {

    Route::prefix('set')->group(function () {
        Route::post('transaction-pin', [\App\Http\Controllers\User\PinController::class, 'transaction'])->name('transaction');
        Route::post('duress-pin', [\App\Http\Controllers\User\PinController::class, 'duress'])->name('duress');
        Route::post('passcode', [\App\Http\Controllers\User\PinController::class, 'passcode'])->name('passcode');
    });

    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::controller(\App\Http\Controllers\User\TransactionController::class)->prefix('transactions')->group(function () {
        Route::get('', 'index');
        Route::post('', 'store');
        Route::delete('/{transaction}', 'destroy');
    });

});
