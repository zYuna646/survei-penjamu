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
use App\Livewire\Dashboard;
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
use App\Livewire\DetailSurvei;
use App\Livewire\CreateSurvei;
use App\Livewire\RunSurvei;
use App\Livewire\RecapSurvei;
use App\Livewire\ListSurvei;
use App\Livewire\CompleteSurvei;
use App\Livewire\UserFakultas;
use App\Livewire\UserProdi;
use App\Livewire\EditUserProdi;
use App\Livewire\UserJurusan;
use App\Livewire\EditUserJurusan;
use App\Livewire\EditUserFakultas;
use App\Livewire\ManipulationSurvei;



Route::get('/login', Auth::class)->name('login');
Route::get('/', Landing::class)->name('home');
Route::get('/list_survei', ListSurvei::class)->name('list_survei');
Route::get('/run_survei/{code}', RunSurvei::class)->name('run_survei');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
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
    Route::get('/detail_survei/{id}', DetailSurvei::class)->name('detail_survei');
    Route::get('/create_survei/{id}', CreateSurvei::class)->name('create_survei');
    Route::get('/recap_survei', RecapSurvei::class)->name('recap_survei');
   

    Route::get('/user_prodi', UserProdi::class)->name('user_prodi');
    Route::get('/edit_user_prodi/{id}', EditUserProdi::class)->name('edit_user_prodi');
    Route::get('/user_fakultas', UserFakultas::class)->name('user_fakultas');
    Route::get('/edit_user_fakultas/{id}', EditUserFakultas::class)->name('edit_user_fakultas');
    Route::get('/manipulation_survei/{id}', ManipulationSurvei::class)->name('manipulation_survei');
});
