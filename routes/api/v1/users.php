<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

        // Route::get('/users','UserController@index');
        Route::get('/users', [UserController::class, 'index']);

        Route::get('/users/{user}', [UserController::class, 'show']);

        Route::post('/users', [UserController::class, 'store']);

        Route::patch('/users/{user}', [UserController::class, 'update']);

        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });
