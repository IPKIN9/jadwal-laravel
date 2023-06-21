<?php

use Illuminate\Support\Facades\Route;

Route::get('/kelas', function () {
    return view('page.Kelas');
});

Route::get('/jurusan', function () {
    return view('page.Jurusan');
});
