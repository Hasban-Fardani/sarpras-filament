<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomResetPasswordController;

Route::get('/', [LoginController::class, 'index'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');


Route::get('/reset-password/{token}', [CustomResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [CustomResetPasswordController::class, 'reset'])
    ->name('password.update');
