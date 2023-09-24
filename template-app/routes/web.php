<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('index');
});

Route::get('/welcome', function () {
    return view('welcome');
});

//Authentiation/registration
Route::get('/login', [AuthController::class, 'login']);
Route::get('/registration', [AuthController::class, 'registration']);
Route::post('/regUser', [AuthController::class, 'regUser'])->name('regUser');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logUser', [AuthController::class, 'logUser'])->name('logUser');






Route::get('/generate/{id}', [MainController::class, 'make_doc'])->where('id', '[0-9]+');

Route::post('/generate/{id}/download', [MainController::class, 'download_doc'])->where('id', '[0-9]+');
