<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'Hisaab API is working!',
    ]);
});


Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', [AuthController::class, 'me']);

        Route::post('/logout', [AuthController::class, 'logout']);


        Route::middleware('auth:sanctum')->group(function () {

            Route::get('/groups', [GroupController::class, 'index']);

            Route::post('/groups', [GroupController::class, 'store']);

        });

    });

});