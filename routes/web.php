<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.horarios')->name('horarios');
Route::view('/talleres', 'pages.talleres')->name('talleres');
Route::view('/carteles', 'pages.carteles')->name('carteles');
Route::view('/asociacion', 'pages.asociacion')->name('asociacion');
Route::view('/online', 'pages.online')->name('online');
Route::view('/mi-camino', 'pages.mi-camino')->name('mi-camino');
