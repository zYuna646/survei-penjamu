<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');
Route::get('/survey', function () {
    return view('admin.survey');
})->name('survey');
Route::get('/student', function () {
    return view('admin.student');
})->name('student');
Route::get('/lecture', function () {
    return view('admin.lecture');
})->name('lecture');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
