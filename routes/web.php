<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

