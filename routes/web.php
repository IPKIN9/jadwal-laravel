<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('page.Login');
})->name('login');

Route::get('/', function () {
    return view('page.Jadwal');
})->middleware(['auth:sanctum']);

Route::get('/kelas', function () {
    return view('page.Kelas');
})->middleware(['auth:sanctum']);

Route::get('/mapel', function () {
    return view('page.Mapel');
})->middleware(['auth:sanctum']);

Route::get('/jurusan', function () {
    return view('page.Jurusan');
})->middleware(['auth:sanctum']);

Route::get('/pangkat', function () {
    return view('page.Pangkat');
})->middleware(['auth:sanctum']);

Route::get('/guru', function () {
    return view('page.Guru');
})->middleware(['auth:sanctum']);

Route::get('/report', function () {
    return view('page.Report');
})->middleware(['auth:sanctum']);