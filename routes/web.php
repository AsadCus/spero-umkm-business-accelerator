<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { return view('index'); });

Route::get('/umkmDanSkor', function () { return view('UMKM.umkmDanSkor'); });
Route::get('/umkmQualified', function () { return view('UMKM.umkmQualified'); });

Route::get('/dashboardPemrograman', function () { return view('Pemrograman.dashboardPemrograman'); });
Route::get('/pemrogramanUmkmDanSkor', function () { return view('Pemrograman.umkmDanSkor'); });

Route::get('/kuisionerPemrograman', function () { return view('Management.kuisionerPemrograman'); });
Route::get('/kuisionerSkor', function () { return view('Management.kuisionerSkor'); });
Route::get('/kuisionerUmkm', function () { return view('Management.kuisionerUmkm'); });
Route::get('/settingKuisionerPemrograman', function () { return view('Management.settingKuisionerPemrograman'); });
Route::get('/settingQualifiedUmkm', function () { return view('Management.settingQualifiedUmkm'); });

