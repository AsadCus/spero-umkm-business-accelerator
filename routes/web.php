<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\Settings\ScoreController;
use App\Http\Controllers\Settings\SetScoreController;

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

Route::post(
    '/stripe/webhook',
    [\App\Http\Controllers\Webhook\StripeController::class, 'handleWebhook']
)->name('cashier.webhook');


Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [\App\Http\Controllers\SuperLoginController::class, 'index'])->name("login");
    Route::post('/process-login', [\App\Http\Controllers\SuperLoginController::class, 'submitLogin'])->name('process-login');
});

Route::redirect('/', '/login');

// Route::group(['middleware' => ['auth']], function() {
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name("/dashboard");
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name("/dashboard");
Route::get('/set-level', [\App\Http\Controllers\SetLevelController::class, 'index'])->name("/set-level");
Route::post('/add-level', [\App\Http\Controllers\SetLevelController::class, 'addLevel'])->name("/add-level");
Route::get('/delete-level/{id}', [\App\Http\Controllers\SetLevelController::class, 'deleteLevel'])->name("/delete-level/{id}");
Route::get('/delete-logic/{id}/{key}', [\App\Http\Controllers\SetLevelController::class, 'deleteLogic'])->name("/delete-logic/{id}/{key}");
Route::get('/set-logic/{id}', [\App\Http\Controllers\SetLevelController::class, 'setLogic'])->name("/set-logic/{id}");
Route::post('/add-logic', [\App\Http\Controllers\SetLevelController::class, 'addLogic'])->name("/add-logic");

// user
Route::controller(UserController::class)->prefix('/akun')->name('akun')->group(function () {
    Route::prefix('/admin')->name('admin')->group(function () {
        Route::get('/', 'getUserAdmin')->name('index');
    });
    Route::prefix('/penyedia')->name('penyedia')->group(function () {
        Route::get('/', 'getUserPenyedia')->name('index');
    });
    Route::prefix('/kurator')->name('kurator')->group(function () {
        Route::get('/', 'getUserKurator')->name('index');
    });
    Route::prefix('/umkm')->name('umkm')->group(function () {
        Route::get('/', 'getUserPeserta')->name('index');
    });
});

// score
Route::controller(ScoreController::class)->prefix('/score')->name('score.')->group(function () {
    Route::get('/', 'index')->name("index");
    Route::post('/post', 'post')->name('post');
    Route::get('/delete/{id}', 'delete')->name('delete');
});

// setting score
Route::controller(SetScoreController::class)->prefix('/kuesioner-skor')->name('kuesioner-skor.')->group(function () {
    Route::get('/', 'index')->name("index");
    Route::get('/show/{id}', 'show')->name('show');
    Route::post('/store', 'store')->name('store');
    Route::post('/update/{id}', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');
    Route::prefix('/logic')->name('logic.')->group(function () {
        Route::get('/edit/{id}', 'editScoreLogic')->name('edit');
        Route::post('/store', 'storeScoreLogic')->name('store');
        Route::post('/update', 'updateScoreLogic')->name('update');
        Route::get('/delete/{id}', 'deleteScoreLogic')->name('delete');
    });
});

Route::controller(KuesionerController::class)->group(function () {
    Route::get('/umkm-unverif', 'unVerif')->name("umkm-unverif");
    Route::get('/umkm-qualified', 'qualified')->name("umkm-qualified");
    Route::get('/umkm-unqualified', 'unqualified')->name("umkm-unualified");
    Route::get('/kuesioner-all', 'all')->name("kuesioner-all");
    Route::get('/kuesioner/{id}', 'getKuesioner')->name("kuesioner");
    Route::post('/submit-verif', 'doVerif')->name("submit-verif");
    Route::get('/verif-page/{id}', 'verification')->name("verif-page");
    Route::get('/detail-data/{id}', 'detailData')->name("detail-data");
    Route::get('/rollback-data/{id}', 'rollback')->name("rollback-data");
    Route::get('/export-data-unverif', 'exportKuesionerUnverif')->name("/export-data-unverif");
    Route::post('/export-verif', 'exportKuesionerVerif')->name("/export-verif");
    Route::get('/export-kuesioner/{id}', 'exportKuesioner')->name("/export-kuesioner/{id}");
    Route::get('/regenerate-pdf/{id}', 'generate_ulang_pdf');
    Route::get('/management-sertifikat', 'managementSertifikat');
    Route::post('/all-generate-pdf', 'all_generate_pdf');
    Route::get('/zipdownload', 'zipdownload');

    // wilayah
    Route::get('/get-kabupaten/{id}', 'getKabupaten');
    Route::get('/get-kecamatan/{id}', 'getKecamatan');
    Route::get('/get-kelurahan/{id}', 'getKelurahan');
});

Route::get('/logout', [\App\Http\Controllers\SuperLoginController::class, 'logout'])->name("logout");
Route::get('/import-data', [\App\Http\Controllers\ImportController::class, 'index'])->name("import-data");
Route::post('/import', [\App\Http\Controllers\ImportController::class, 'importData'])->name("import");

Route::get('/list-kategori-materi', [\App\Http\Controllers\LmsController::class, 'listKategori'])->name("list-kategori-materi");
Route::post('/add-kategori', [\App\Http\Controllers\LmsController::class, 'addKategori'])->name("/add-kategori");

Route::get('/list-materi', [\App\Http\Controllers\LmsController::class, 'listMateri'])->name("list-materi");
Route::post('/add-materi', [\App\Http\Controllers\LmsController::class, 'addMateri'])->name("add-materi");

Route::get('/{name}/sub-materi/{id}/', [\App\Http\Controllers\LmsController::class, 'subMateri']);
Route::post('/add-sub-materi/{id}/{name}', [\App\Http\Controllers\LmsController::class, 'addSubMateri'])->name("add-sub-materi/{id}/{name}");
Route::get('/approve-materi/{id}/', [\App\Http\Controllers\LmsController::class, 'approve'])->name("approve-materi/{id}");

Route::get('/list-pengumuman', [\App\Http\Controllers\LmsController::class, 'listPengumuman'])->name("list-pengumuman");
Route::post('/add-pengumuman', [\App\Http\Controllers\LmsController::class, 'addPengumuman'])->name("add-pengumuman");
Route::get('/edit-pengumuman/{id}', [\App\Http\Controllers\LmsController::class, 'editPengumuman'])->name("edit-pengumuman/{id}");
Route::put('/update-pengumuman/{id}', [\App\Http\Controllers\LmsController::class, 'updatePengumuman'])->name("update-pengumuman/{id}");
Route::put('/hapus-pengumuman/{id}', [\App\Http\Controllers\LmsController::class, 'deletePengumuman'])->name("hapus-pengumuman/{id}");

Route::get('/old-portal', [\App\Http\Controllers\OldPortalController::class, 'index'])->name("old-portal");
Route::get('/user-progres', [\App\Http\Controllers\LmsController::class, 'user_progres'])->name("user-progres");
Route::get('/user-progres/{id}/materi/{materiid}', [\App\Http\Controllers\LmsController::class, 'detail_user_progres']);
Route::get('/sub-materi/{id}', [\App\Http\Controllers\LmsController::class, 'detail_sub_materi']);
Route::get('/edit-sub-materi/{id}', [\App\Http\Controllers\LmsController::class, 'edit_sub_materi']);
Route::put('/update-sub-materi/{id}', [\App\Http\Controllers\LmsController::class, 'update_sub_materi']);
Route::put('/hapus-submateri/{id}', [\App\Http\Controllers\LmsController::class, 'deleteSubmateri']);

Route::get('/materi-chatting', [\App\Http\Controllers\LmsController::class, 'materi_chatting']);
Route::get('/materi-chatting/{id}/materi/{name}', [\App\Http\Controllers\LmsController::class, 'materi_chatting_by_id']);
Route::get('/sub-materi-chatting/{id}', [\App\Http\Controllers\LmsController::class, 'sub_materi_chatting_by_id']);
Route::get('/send-pdf/{id}', [\App\Http\Controllers\MailController::class, 'send'])->name("send-pdf");
Route::post('/send-chatting', [\App\Http\Controllers\LmsController::class, 'send_chatting']);
Route::post('/import-excel', [\App\Http\Controllers\ImportController::class, 'import_penerima_sertifikat']);

// Route::get('/export-verif', [\App\Http\Controllers\KuesionerController::class, 'exportKuesionerVerif'])->name("export-verif");
// });

Route::get('/preview-pdf/{id}', [\App\Http\Controllers\LmsController::class, 'downloadPdf']);

// route wilayah
Route::get('/provinsi', [\App\Http\Controllers\WilayahController::class, 'list_provinsi']);
Route::get('/form-input-provinsi', [\App\Http\Controllers\WilayahController::class, 'form_input_provinsi']);
Route::post('/add-provinsi', [\App\Http\Controllers\WilayahController::class, 'add_provinsi']);
Route::get('/form-edit-provinsi/{id}', [\App\Http\Controllers\WilayahController::class, 'form_edit_provinsi']);
Route::put('/update-provinsi/{id}', [\App\Http\Controllers\WilayahController::class, 'update_provinsi']);
Route::put('/delete-provinsi/{id}', [\App\Http\Controllers\WilayahController::class, 'delete_provinsi']);

Route::get('/kabupaten', [\App\Http\Controllers\WilayahController::class, 'list_kabupaten']);
Route::get('/form-input-kabupaten', [\App\Http\Controllers\WilayahController::class, 'form_input_kabupaten']);
Route::post('/add-kabupaten', [\App\Http\Controllers\WilayahController::class, 'add_kabupaten']);
Route::get('/form-edit-kabupaten/{id}', [\App\Http\Controllers\WilayahController::class, 'form_edit_kabupaten']);
Route::put('/update-kabupaten/{id}', [\App\Http\Controllers\WilayahController::class, 'update_kabupaten']);
Route::put('/delete-kabupaten/{id}', [\App\Http\Controllers\WilayahController::class, 'delete_kabupaten']);

Route::get('/kecamatan', [\App\Http\Controllers\WilayahController::class, 'list_kecamatan']);
Route::get('/form-input-kecamatan', [\App\Http\Controllers\WilayahController::class, 'form_input_kecamatan']);
Route::post('/add-kecamatan', [\App\Http\Controllers\WilayahController::class, 'add_kecamatan']);
Route::get('/form-edit-kecamatan/{id}', [\App\Http\Controllers\WilayahController::class, 'form_edit_kecamatan']);
Route::put('/update-kecamatan/{id}', [\App\Http\Controllers\WilayahController::class, 'update_kecamatan']);
Route::put('/delete-kecamatan/{id}', [\App\Http\Controllers\WilayahController::class, 'delete_kecamatan']);
Route::get('/get-kabupaten-by-provinsi/{id}', [\App\Http\Controllers\WilayahController::class, 'get_kabupaten_by_provinsi']);
Route::get('/get-kecamatan-by-kabupaten/{id}', [\App\Http\Controllers\WilayahController::class, 'get_kecamatan_by_kabupaten']);

Route::get('/kelurahan', [\App\Http\Controllers\WilayahController::class, 'list_kelurahan']);
Route::get('/form-input-kelurahan', [\App\Http\Controllers\WilayahController::class, 'form_input_kelurahan']);
Route::post('/add-kelurahan', [\App\Http\Controllers\WilayahController::class, 'add_kelurahan']);
Route::get('/form-edit-kelurahan/{id}', [\App\Http\Controllers\WilayahController::class, 'form_edit_kelurahan']);
Route::put('/update-kelurahan/{id}', [\App\Http\Controllers\WilayahController::class, 'update_kelurahan']);
Route::put('/delete-kelurahan/{id}', [\App\Http\Controllers\WilayahController::class, 'delete_kelurahan']);
Route::get('/hashids/{id}', [\App\Http\Controllers\Auth\UserController::class, 'test']);


Route::post(
    '/vapor/signed-storage-url',
    [\App\Http\Controllers\Content\SignedStorageUrlController::class, 'store']
)->middleware([]);
// Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'getSitemap'])->name('sitemap');
Route::group(['middleware' => ['cors']], function () {
    Route::post('/get-file', [App\Http\Controllers\LmsController::class, 'get_file_by_name']);
});
// });
