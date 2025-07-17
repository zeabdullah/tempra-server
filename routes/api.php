<?php

use App\Http\Controllers\TimeCapsuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/time_capsules', [TimeCapsuleController::class, 'getAllTimeCapsules']);
