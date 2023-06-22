<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailJadwalController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PangkatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/oauth')->controller(AuthController::class)->group(function() {
    Route::post('/token', 'getToken');
});

Route::prefix('v1/users')->controller(UserController::class)->group(function () {
    Route::get   ('/'     , 'getAllData' );
    Route::get   ('/{id}' , 'getById'    );
    Route::post  ('/'     , 'upsertData' );
    Route::delete('/{id}' , 'deleteData' );
});

Route::prefix('v1/jurusan')->controller(JurusanController::class)->middleware(['auth:sanctum', 'ability:all-action'])->group(function () {
    Route::get   ('/'     , 'getAllData' );
    Route::get   ('/{id}' , 'getById'    );
    Route::post  ('/'     , 'upsertData' );
    Route::delete('/{id}' , 'deleteData' );
});

Route::prefix('v1/pangkat')->controller(PangkatController::class)->group(function () {
    Route::get   ('/'     , 'getAllData' );
    Route::get   ('/{id}' , 'getById'    );
    Route::post  ('/'     , 'upsertData' );
    Route::delete('/{id}' , 'deleteData' );
});

Route::prefix('v1/kelas')->controller(KelasController::class)->group(function () {
    Route::get   ('/'     , 'getAllData' );
    Route::get   ('/{id}' , 'getById'    );
    Route::post  ('/'     , 'upsertData' );
    Route::delete('/{id}' , 'deleteData' );
});

Route::prefix('v1/mapel')->controller(MapelController::class)->group(function () {
    Route::get   ('/'     , 'getAllData' );
    Route::get   ('/{id}' , 'getById'    );
    Route::post  ('/'     , 'upsertData' );
    Route::delete('/{id}' , 'deleteData' );
});

Route::prefix('v1/guru')->controller(GuruController::class)->group(function () {
    Route::get   ('/'     , 'getAllData' );
    Route::get   ('/{id}' , 'getById'    );
    Route::post  ('/'     , 'upsertData' );
    Route::delete('/{id}' , 'deleteData' );
});

Route::prefix('v1/detail/jadwal')->controller(DetailJadwalController::class)->group(function () {
    Route::get   ('/'     , 'getAllData' );
    Route::get   ('/{id}' , 'getById'    );
    Route::post  ('/'     , 'upsertData' );
    Route::delete('/{id}' , 'deleteData' );
});

Route::prefix('v1/detail/scanning')->controller(DetailJadwalController::class)->group(function () {
    Route::get('/', 'scanningData');
});

Route::prefix('v1/report')->controller(ReportController::class)->group(function () {
    Route::get('/jadwal', 'getJadwalReport');
});