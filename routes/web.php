<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('index');
});

Route::get('/kuisioner', function () {
    return view('setting.kuisioner');
});
Route::get('/kuisioner-skor', function () {
    return view('setting.kuisioner-skor');
});
Route::get('/show/kuisioner-soal', function () {
    return view('setting.kuisioner-soal');
});
Route::get('/kuisioner-kurasi', function () {
    return view('setting.kuisioner-kurasi');
});
Route::get('/tambah-kuisioner-kurasi', function () {
    return view('setting.tambah-kuisioner-kurasi');
});

Route::get('/umkm-qualified', function () {
    return view('kurasi.qualified');
});
Route::get('/umkm-assesment', function () {
    return view('kurasi.assesment');
});

Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
    Route::get('/admin', function () {
        return view('user.admin');
    });
    Route::get('/kurator', function () {
        return view('user.kurator');
    });
    Route::get('/penyedia', function () {
        return view('user.penyedia');
    });
    Route::get('/umkm', function () {
        return view('user.umkm');
    });
});

Route::get('/umkm-registered', function () {
    return view('umkm.registered');
});
Route::get('/umkm-qualified', function () {
    return view('umkm.qualified');
});
Route::get('/umkm-unqualified', function () {
    return view('umkm.unqualified');
});
Route::get('/umkm-verified', function () {
    return view('umkm.verified');
});
