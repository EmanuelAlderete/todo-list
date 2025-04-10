<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'task-list' => TaskListController::class,
        'task' => TaskController::class,
    ]);
});
