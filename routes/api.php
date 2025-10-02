<?php

use App\Helpers\Routes\RouteHelper;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){
    RouteHelper::includeRouteFiles(__DIR__ . '/api/v1');
});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
