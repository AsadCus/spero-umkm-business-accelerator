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
Route::get('/1', function () { return view('1.1'); });
Route::get('/2', function () { return view('2.2'); });
Route::get('/3', function () { return view('3.3'); });
Route::get('/4', function () { return view('4.4'); });
Route::get('/5', function () { return view('5.5'); });
