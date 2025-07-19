<?php

use App\Http\Controllers\TimeCapsuleController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::get('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'time_capsules'], function () {
    Route::get('/', [TimeCapsuleController::class, 'search']);
    Route::post('/', [TimeCapsuleController::class, 'create']);
    Route::patch('/{id}', [TimeCapsuleController::class, 'update']);
    Route::delete('/{id}', [TimeCapsuleController::class, 'delete']);
});


