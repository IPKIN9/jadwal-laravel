<?php

use Illuminate\Support\Facades\Route;

Route::get('/kelas', function () {
    return view('page.Kelas');
});

Route::get('/mapel', function () {
    return view('page.Mapel');
});

Route::get('/jurusan', function () {
    return view('page.Jurusan');
});

Route::get('/pangkat', function () {
    return view('page.Pangkat');
});