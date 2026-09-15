<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::Post('/register', [UserController::class, 'register']);
Route::Post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::Post('/profile', [UserController::class, 'profile']);
    Route::Post('/logout', [UserController::class, 'logout']);
});
