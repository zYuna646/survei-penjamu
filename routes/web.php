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
use App\Livewire\AdminDashboard;
use App\Livewire\MasterFakultas;

Route::get('/auth', Auth::class)->name('auth');
Route::get('/landing', Landing::class)->name('landing');
Route::get('/admin_dashboard', AdminDashboard::class)->name('admin_dashboard');
Route::get('/master_fakultas', MasterFakultas::class)->name('master_fakultas');
