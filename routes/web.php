<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/process', [AuthController::class, 'getToken'])->name('login.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('page.Jadwal');
})->middleware('auth')->name('dashboard');

Route::get('/kelas', function () {
    return view('page.Kelas');
})->middleware('auth');

Route::get('/mapel', function () {
    return view('page.Mapel');
})->middleware('auth');

Route::get('/jurusan', function () {
    return view('page.Jurusan');
})->middleware('auth');

Route::get('/pangkat', function () {
    return view('page.Pangkat');
})->middleware('auth');

Route::get('/guru', function () {
    return view('page.Guru');
})->middleware('auth');

Route::get('/report', function () {
    return view('page.Report');
})->middleware('auth');