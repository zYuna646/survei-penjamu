<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiSurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/target', [ApiController::class, 'getTarget']);
Route::get('/fakultas', [ApiController::class, 'getFakultas']);
Route::get('/fakultas/{id}', [ApiController::class, 'getFakultasById']);
Route::get('/prodi', [ApiController::class, 'getProdi']);
Route::get('/prodi/{id}', [ApiController::class, 'getProdiById']);
Route::get('/survey', [ApiController::class, 'getSurvey']);
Route::get('/survey/{id}', [ApiController::class, 'getSurveyById']);
Route::get('/survey/{id}/detail', [ApiSurveyController::class, 'getSurveyDetailById']);
Route::get('/aspek/{id}', [ApiController::class, 'getAspekById']);
Route::get('/indikator/{id}', [ApiController::class, 'getIndikatorById']);

Route::get('/temuan/universitas/{id}', [ApiController::class, 'getTemuanUniv']);
Route::get('/temuan/fakultas/{id}', [ApiController::class, 'getTemuanFakultas']);
Route::get('/temuan/fakultas/{id}/{fakultas_id}', [ApiController::class, 'getTemuanFakultasById']);

Route::get('/temuan/prodi/{id}', [ApiController::class, 'getTemuanProdi']);
Route::get('/temuan/prodi/{id}/{prodi_id}', [ApiController::class, 'getTemuanProdiById']);
Route::get('/survei/{id}/{fakultas_id}', [ApiController::class, 'getSurvei']);
Route::get('/survei/{id}/prodi/{prodi_id}', [ApiController::class, 'getSurveiByProdi']);