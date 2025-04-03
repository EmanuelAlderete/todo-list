<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');
