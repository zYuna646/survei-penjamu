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
use App\Livewire\EditFakultas;
use App\Livewire\MasterProdi;
use App\Livewire\EditProdi;

Route::get('/auth', Auth::class)->name('auth');
Route::get('/landing', Landing::class)->name('landing');
Route::get('/admin_dashboard', AdminDashboard::class)->name('admin_dashboard');
Route::get('/master_fakultas', MasterFakultas::class)->name('master_fakultas');
Route::get('/edit_fakultas/{id}', EditFakultas::class)->name('edit_fakultas');
Route::get('/master_prodi', MasterProdi::class)->name('master_prodi');
Route::get('/edit_prodi/{id}', EditProdi::class)->name('edit_prodi');