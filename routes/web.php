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

Route::get('/kuisioner', function () { return view('Setting.kuisioner'); });
Route::get('/kuisionerskor', function () { return view('Setting.kuisionerskor'); });
Route::get('/kuisionerkurasi', function () { return view('Setting.kuisionerkurasi'); });

Route::get('/umkmqualified', function () { return view('Kurasi.umkmqualified'); });
Route::get('/umkmassesment', function () { return view('Kurasi.umkmassesment'); });

Route::get('/admin', function () { return view('Akun.admin'); });
Route::get('/kurator', function () { return view('Akun.kurator'); });
Route::get('/penyedia', function () { return view('Akun.penyedia'); });
Route::get('/umkm', function () { return view('Akun.umkm'); });

Route::get('/umkmregistered', function () { return view('Umkm.umkmregistered'); });
Route::get('/umkmqualified', function () { return view('Umkm.umkmqualified'); });
Route::get('/umkmunqualified', function () { return view('Umkm.umkmunqualified'); });
Route::get('/umkmverified', function () { return view('Umkm.umkmverified'); });


