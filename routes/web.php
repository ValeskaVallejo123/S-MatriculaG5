<?php

use Illuminate\Support\Facades\Route;


/*Route::get('/', function () {
    return view('welcome'); // o tu vista principal
});*/

Route::get('/', function () {
    return view('plantilla');
});

Route::get('/login', function () {
    return view('login');
})->name('login');









