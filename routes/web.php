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

use App\Livewire\Landing;
use App\Livewire\Auth;

Route::get('/auth', Auth::class)->name('auth');
Route::get('/landing', Landing::class)->name('landing');
