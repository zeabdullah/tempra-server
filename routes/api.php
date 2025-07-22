<?php

use App\Http\Controllers\TimeCapsuleController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
});

Route::get('/my_time_capsules', [TimeCapsuleController::class, 'searchMine'])->middleware('auth:api');
Route::group(['prefix' => 'time_capsules'], function () {
    Route::get('/', [TimeCapsuleController::class, 'search']);
    Route::post('/', [TimeCapsuleController::class, 'store']);
    Route::get('/{id}', [TimeCapsuleController::class, 'find']);
    Route::put('/{id}', [TimeCapsuleController::class, 'update']);
    Route::delete('/{id}', [TimeCapsuleController::class, 'delete']);
});
