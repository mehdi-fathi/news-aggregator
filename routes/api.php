<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Version 1
Route::prefix('v1')->group(function () {
    Route::prefix('news')->group(function () {
        Route::get('/list', [\App\Http\Controllers\Api\NewsController::class, 'list']);
        Route::get('/search', [\App\Http\Controllers\Api\NewsController::class, 'search']);
    });

    Route::prefix('user-preference')->group(function () {
        Route::get('/list', [\App\Http\Controllers\Api\UserPreferenceController::class, 'list']);
        Route::post('/store', [\App\Http\Controllers\Api\UserPreferenceController::class, 'store']);
        Route::put('/update', [\App\Http\Controllers\Api\UserPreferenceController::class, 'update']);
        Route::delete('/delete', [\App\Http\Controllers\Api\UserPreferenceController::class, 'delete']);
    });
});
