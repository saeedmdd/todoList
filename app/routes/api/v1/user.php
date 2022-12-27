<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;

Route::post('register', [UserController::class, 'register'])->name("register");
Route::post('login', [UserController::class, 'login'])->name("login");
