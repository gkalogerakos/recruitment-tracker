<?php

use App\Http\Controllers\Api\TimelineController;
use Illuminate\Support\Facades\Route;


Route::post('/timeline', [TimelineController::class, 'store']);
