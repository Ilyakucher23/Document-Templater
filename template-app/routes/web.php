<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

//Template listing
Route::get('/', [MainController::class, 'templates']);

// Route::get('/', function () {
//     return view('index');
// });
// Route::get('/welcome', function () {
//     return view('welcome');
// });
Route::get('/generate/{id}', [MainController::class, 'make_doc'])->where('id', '[0-9]+');

Route::post('/generate/{id}/download', [MainController::class, 'download_doc'])->where('id', '[0-9]+');

Route::get('/editor', [MainController::class, 'editor']);
Route::post('/save', [MainController::class, 'save']);

//Authentiation/registration
Route::get('/login', [AuthController::class, 'login']);
Route::get('/registration', [AuthController::class, 'registration']);
Route::post('/regUser', [AuthController::class, 'regUser'])->name('regUser');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logUser', [AuthController::class, 'logUser'])->name('logUser');



Route::get('/test', [AuthController::class, 'createUserFolder'])->name('test');
