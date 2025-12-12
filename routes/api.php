<?php

use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\StepController;
use App\Http\Controllers\Api\TimelineController;
use Illuminate\Support\Facades\Route;

Route::post('/timelines', [TimelineController::class, 'store']);

Route::get('/timelines/{timeline}', [TimelineController::class, 'show']);

Route::post('/steps', [StepController::class, 'store']);

Route::post('/statuses', [StatusController::class, 'store']);
