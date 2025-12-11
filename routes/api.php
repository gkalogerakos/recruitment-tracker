<?php

use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\StepController;
use App\Http\Controllers\Api\TimelineController;
use Illuminate\Support\Facades\Route;


Route::post('/timeline', [TimelineController::class, 'store']);

Route::post('/step', [StepController::class, 'store']);

Route::post('/status', [StatusController::class, 'store']);
