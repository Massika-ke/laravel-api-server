<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/posts', [PostController::class, 'index']);

        Route::get('/posts/{post}', [PostController::class, 'show']);

        Route::post('/posts', [PostController::class, 'store']);

        Route::patch('/posts/{post}', [PostController::class, 'update']);

        Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    });
