<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\TaskController;

Route::apiResource("/", TaskController::class)->parameter("", "task");
