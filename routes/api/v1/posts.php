<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/posts','PostController@index');

        Route::get('/posts/{post}', [PostController::class, 'show']);

        Route::post('/posts', [PostController::class, 'store']);

        Route::patch('/posts/{post}', [PostController::class, 'update']);

        Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    });
