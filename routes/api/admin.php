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
        'message' => 'admin test route is working'
    ], 200);
});

// A U T H E N T I C A T E D     R O U T E S
Route::middleware(['auth:admin-api', 'scopes:admin'])->group(function () {

});
