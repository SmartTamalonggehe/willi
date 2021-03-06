<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DashboardController@index')->name('Bendahara');
Route::get('kasGrafik', 'DashboardController@kasGrafik')->name('kasGrafik');

Route::resource('jenisPemasukan', 'JenisPemasukanController');
Route::resource('jenisPengeluaran', 'JenisPengeluaranController');
Route::resource('pemasukan', 'PemasukanController');
Route::resource('pengeluaran', 'PengeluaranController');
Route::resource('perpuluhan', 'PerpuluhanController');

Route::get('/tampilKas', 'KasController@tampilKas')->name('tampilKas');

Route::get('/kasExportExcel', 'KasController@kasExportExcel')->name('kasExportExcel');

Route::get('/lapPemasukan', 'LapPemasukanController@pemasukan')->name('lapPemasukan');
