<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/login','PandaLoginController@showLoginForm')->name('pemilih.login');

// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'operator'], function () {
    Auth::routes();
    Route::get('/dashboard','Operator\DashboardOperatorController@dashboard')->name('operator.dashboard');
});

Route::group(['prefix' => 'pemilih'], function () {
    Route::post('/pandalogin','PandaLoginController@pandaLogin')->name('panda.login.post');
    Route::get('/user_logout','PandaLoginController@pandaLogout')->name('panda.logout');
    Route::get('/dashboard','Pemilih\DashboardPemilihController@dashboard')->name('pemilih.dashboard');
    Route::post('/pilih/{id}/{slug}','Pemilih\DashboardPemilihController@pemilihPost')->name('pemilih.pilih');
});

Route::group(['prefix' => 'kandidat'], function () {
    Route::get('/','Operator\KandidatController@index')->name('operator.kandidat');
    Route::get('/tambah','Operator\KandidatController@add')->name('operator.kandidat.add');
    Route::post('/tambah','Operator\KandidatController@post')->name('operator.kandidat.post');
    Route::get('/tambah_detail/{id}/{slug}','Operator\KandidatController@addDetail')->name('operator.kandidat.add_detail');
    Route::post('/tambah_detail/{id}','Operator\KandidatController@detailPost')->name('operator.kandidat.detail_post');
    Route::get('/{id}/{slug}/edit','Operator\KandidatController@edit')->name('operator.kandidat.edit');
    Route::patch('/update','Operator\KandidatController@update')->name('operator.kandidat.update');

    Route::patch('/aktifkan_status/{id}','Operator\KandidatController@aktifkanStatus')->name('operator.kandidat.aktifkan_status');
    Route::patch('/nonaktifkan_status/{id}','Operator\KandidatController@nonAktifkanStatus')->name('operator.kandidat.nonaktifkan_status');
});

Route::group(['prefix' => 'jadwal_pemira'], function () {
    Route::get('/','Operator\JadwalController@index')->name('operator.jadwal');
    Route::post('/tambah','Operator\JadwalController@post')->name('operator.jadwal.post');
    Route::delete('/hapus','Operator\JadwalController@delete')->name('operator.jadwal.delete');
    Route::patch('/aktifkan_status/{id}','Operator\JadwalController@aktifkanStatus')->name('operator.jadwal.aktifkan_status');
});

Route::group(['prefix' => 'rekapitulasi'], function () {
    Route::get('/keseluruhan','Operator\RekapController@laporanKeseluruhan')->name('operator.laporan.keseluruhan');
    Route::get('/per_prodi','Operator\RekapController@laporanPerProdi')->name('operator.laporan.prodi');
});