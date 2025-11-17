<?php

use App\Http\Controllers\Auth\UserLogin;
use App\Http\Controllers\Auth\UserRegister;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/register', [UserRegister::class, 'register']);
Route::post('/login', [UserLogin::class, 'login']);
