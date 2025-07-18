<?php

use App\Http\Controllers\TimeCapsuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'time_capsules'], function () {
    Route::get('/', [TimeCapsuleController::class, 'get']);
    Route::post('/', [TimeCapsuleController::class, 'create']);
    Route::patch('/{id}', [TimeCapsuleController::class, 'update']);
    Route::delete('/{id}', [TimeCapsuleController::class, 'delete']);
});

