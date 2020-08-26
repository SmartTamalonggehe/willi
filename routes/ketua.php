<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index')->name('Ketua');
Route::get('kasGrafik', 'DashboardController@kasGrafik')->name('kasGrafik');

Route::get('/tampilKasKetua', 'KasController@tampilKas')->name('tampilKasKetua');

Route::get('/kasExportExcel', 'KasController@kasExportExcel')->name('kasExportExcel');

Route::get('/kasExportPdf', 'KasController@kasExportPdf')->name('kasExportPdf');
