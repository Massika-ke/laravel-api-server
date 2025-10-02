<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){
    require __DIR__ . '/api/v1/users.php';
});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
