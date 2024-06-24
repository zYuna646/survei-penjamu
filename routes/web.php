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
use App\Livewire\MasterJurusan;
use App\Livewire\EditJurusan;
use App\Livewire\MasterTarget;
use App\Livewire\EditTarget;
use App\Livewire\MasterJenis;
use App\Livewire\EditJenis;
use App\Livewire\MasterSurvei;
use App\Livewire\CreateSurvei;



Route::get('/auth', Auth::class)->name('auth');
Route::get('/landing', Landing::class)->name('landing');
Route::get('/admin_dashboard', AdminDashboard::class)->name('admin_dashboard');
Route::get('/master_fakultas', MasterFakultas::class)->name('master_fakultas');
Route::get('/edit_fakultas/{id}', EditFakultas::class)->name('edit_fakultas');
Route::get('/master_prodi', MasterProdi::class)->name('master_prodi');
Route::get('/edit_prodi/{id}', EditProdi::class)->name('edit_prodi');
Route::get('/master_jurusan', MasterJurusan::class)->name('master_jurusan');
Route::get('/edit_jurusan/{id}', EditJurusan::class)->name('edit_jurusan');
Route::get('/master_target', MasterTarget::class)->name('master_target');
Route::get('/edit_target/{id}', EditTarget::class)->name('edit_target');
Route::get('/master_jenis', MasterJenis::class)->name('master_jenis');
Route::get('/edit_jenis/{id}', EditJenis::class)->name('edit_jenis');
Route::get('/master_survei', MasterSurvei::class)->name('master_survei');
Route::get('/create_survei', CreateSurvei::class)->name('create_survei');
