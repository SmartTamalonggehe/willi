<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index')->name('Ketua');

Route::get('/tampilKasKetua', 'KasController@tampilKas')->name('tampilKasKetua');

Route::get('/kasExportExcel', 'KasController@kasExportExcel')->name('kasExportExcel');
