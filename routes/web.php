<?php

use App\Http\Controllers\CriteriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\Register;
use App\Http\Controllers\Home;
use App\Http\Controllers\Konfigurasi_cuti;
use App\Http\Controllers\Manage_karyawan;
use App\Http\Controllers\Manage_staf_hr;
use App\Http\Controllers\Manage_pengajuan_cuti;
use App\Http\Controllers\Rekap_pengajuan_cuti;
use App\Http\Controllers\Cuti_non;
use App\Http\Controllers\Forgot_Password;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganMooraController;
use App\Http\Controllers\PerhitunganTopsisController;
use App\Http\Controllers\PerhitunganWaspasController;
use App\Http\Controllers\Print_tahunan;
use App\Http\Controllers\Print_non_tahunan;
use App\Http\Controllers\RankingController;

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

Route::get('/', [Login::class, 'index']);
Route::get('/login', [Login::class, 'index']);
Route::post('/login-action', [Login::class, 'login_action']);
Route::get('/register', [Register::class, 'index']);
Route::post('/store-register', [Register::class, 'store']);
Route::get('/logout-action', [Login::class, 'logout_action']);
Route::get('/forgot-password', [Forgot_Password::class, 'index']);
// Route untuk mengirim email dengan OTP
Route::post('/forgot-password-action', [Forgot_Password::class, 'sendOTP']);

// Route untuk menampilkan form input OTP
Route::get('/verify-otp', [Forgot_Password::class, 'showOTPForm'])->name('verify-otp');
// Route untuk memverifikasi OTP
Route::get('/verify-otp-action', [Forgot_Password::class, 'verifyOTP']);

// Route untuk menampilkan form input password baru
Route::get('/reset-password', [Forgot_Password::class, 'showResetPasswordForm'])->name('reset-password');
// Route untuk menyimpan password baru
Route::post('/reset-password-action', [Forgot_Password::class, 'resetPassword']);
// Route::post('/store-register', [Register::class,'store']);
//admin
Route::middleware(['authAdmin'])->prefix('admin')->group(function () {
    Route::get('/home', [Home::class, 'index']);
    Route::resource('/konfigurasi-cuti', Konfigurasi_cuti::class);
    Route::resource('/manage-karyawan', Manage_karyawan::class);
    Route::get('/rekap-pengajuan-cuti', [Rekap_pengajuan_cuti::class, 'index'])->name('rekap_pengajuan_cuti.indexAdmin');

    // Route::get('/cuti-non-tahunan', [Cuti_non::class, 'index'])->name('cuti_non.indexAdmin');

    Route::resource('/kriteria', CriteriaController::class);
    Route::get('konversi-pengajuan-cuti/{jenis}', [PerhitunganWaspasController::class, 'index']);
    Route::get('normalisasi-pengajuan-cuti/{jenis}', [PerhitunganWaspasController::class, 'normalisasi']);
    Route::get('hasil-akhir-pengajuan-cuti/{jenis}', [PerhitunganWaspasController::class, 'hasil_akhir']);
});

//staf direktur
Route::middleware(['authDirektur'])->prefix('direktur')->group(function () {
    Route::get('/home', [Home::class, 'index']);
    Route::resource('/manage-karyawan', Manage_karyawan::class);
});

//staf kepala bagian
Route::middleware(['authKepalaBagian'])->prefix('kepala-bagian')->group(function () {
    Route::get('/home', [Home::class, 'index']);


    // Route untuk menampilkan halaman index pengelola
    Route::get('/manage-pengajuan-cuti', [Manage_pengajuan_cuti::class, 'index'])->name('manage_pengajuan_cuti.indexManager');

    // Route untuk menyimpan data pengajuan cuti
    Route::post('/manage-pengajuan-cuti', [Manage_pengajuan_cuti::class, 'store'])->name('manage_pengajuan_cuti.store');

    // Route untuk menampilkan halaman form pengajuan cuti
    Route::get('/manage-pengajuan-cuti/create', [Manage_pengajuan_cuti::class, 'create'])->name('manage_pengajuan_cuti.create');

    // Route untuk menampilkan halaman edit pengajuan cuti
    Route::get('/manage-pengajuan-cuti/{id_pengajuan_cuti}/edit', [Manage_pengajuan_cuti::class, 'edit'])->name('manage_pengajuan_cuti.edit');

    // Route untuk mengupdate data pengajuan cuti
    Route::put('/manage-pengajuan-cuti/{id_pengajuan_cuti}', [Manage_pengajuan_cuti::class, 'update'])->name('manage_pengajuan_cuti.update');

    // Route untuk menghapus data pengajuan cuti
    Route::delete('/manage-pengajuan-cuti/{id_pengajuan_cuti}', [Manage_pengajuan_cuti::class, 'destroy'])->name('manage_pengajuan_cuti.destroy');

    // Route untuk menampilkan halaman print
    Route::get('/manage-pengajuan-cuti/{id_pengajuan_cuti}/print', [Manage_pengajuan_cuti::class, 'print'])->name('manage_pengajuan_cuti.print');


    // Route untuk menampilkan halaman detail pengajuan cuti
    Route::get('/manage-pengajuan-cuti/{id_pengajuan_cuti}', [Manage_pengajuan_cuti::class, 'show'])->name('manage_pengajuan_cuti.show');

    Route::resource('/konfigurasi-cuti', Konfigurasi_cuti::class);
    Route::resource('/manage-karyawan', Manage_karyawan::class);
    Route::resource('/manage-kinerja-kepala-sub-bagian', Manage_karyawan::class);
    Route::get('/manage-kepala-sub-bagian', [Manage_karyawan::class, 'indexKepalaSubBagian']);

    // Route::get('/rekap-pengajuan-cuti', [Rekap_pengajuan_cuti::class,'index']);
    Route::get('/rekap-pengajuan-cuti', [Rekap_pengajuan_cuti::class, 'index'])->name('rekap_pengajuan_cuti.index');



    Route::resource('form-penilaian', PenilaianController::class);
    Route::post('form-penilaian/store', [PenilaianController::class, 'store']);

    Route::get('konversi-alternatif-waspas', [PerhitunganWaspasController::class, 'index']);
    Route::get('hasil-normalisasi-waspas', [PerhitunganWaspasController::class, 'normalisasi']);
    Route::get('hasil-akhir-waspas', [PerhitunganWaspasController::class, 'hasil_akhir']);

    Route::get('konversi-alternatif-moora', [PerhitunganMooraController::class, 'index']);
    Route::get('hasil-normalisasi-moora', [PerhitunganMooraController::class, 'normalisasi']);
    Route::get('hasil-atribut-optimal', [PerhitunganMooraController::class, 'hasil_atribut_optimal']);
    Route::get('hasil-akhir-moora', [PerhitunganMooraController::class, 'hasil_akhir']);

    Route::get('konversi-alternatif-topsis', [PerhitunganTopsisController::class, 'index']);
    Route::get('hasil-normalisasi-topsis', [PerhitunganTopsisController::class, 'normalisasi']);
    Route::get('hasil-normalisasi-terbobot-topsis', [PerhitunganTopsisController::class, 'hasil_normalisasi_terbobot']);
    Route::get('hasil-solusi-ideal-topsis', [PerhitunganTopsisController::class, 'hasil_solusi_ideal']);

    Route::get('hasil-akhir-topsis', [PerhitunganTopsisController::class, 'hasil_akhir']);
    Route::get('ranking', [RankingController::class, 'index']);
});

//staf kepala sub bagian
Route::middleware(['authKepalaSubBagian'])->prefix('kepala-sub-bagian')->group(function () {
    Route::get('/home', [Home::class, 'index']);
    // Route::resource('/manage-pengajuan-cuti', Manage_pengajuan_cuti::class);
    // Route::get('/manage-pengajuan-cuti', [Manage_pengajuan_cuti::class, 'index_pengelolaa'])->name('manage_pengajuan_cuti.index_pengelolaa');
    // Route::resource('/cuti-non-tahunan', Cuti_non::class);

    // Route untuk menampilkan halaman index pengelola
    Route::resource('/manage-karyawan', Manage_karyawan::class);
    Route::resource('/form-penilaian', PenilaianController::class);
    Route::post('/form-penilaian/store', [PenilaianController::class, 'store']);
    Route::get('konversi-alternatif-waspas', [PerhitunganWaspasController::class, 'index']);
    Route::get('hasil-normalisasi-waspas', [PerhitunganWaspasController::class, 'normalisasi']);
    Route::get('hasil-akhir-waspas', [PerhitunganWaspasController::class, 'hasil_akhir']);

    Route::get('konversi-alternatif-moora', [PerhitunganMooraController::class, 'index']);
    Route::get('hasil-normalisasi-moora', [PerhitunganMooraController::class, 'normalisasi']);
    Route::get('hasil-atribut-optimal', [PerhitunganMooraController::class, 'hasil_atribut_optimal']);
    Route::get('hasil-akhir-moora', [PerhitunganMooraController::class, 'hasil_akhir']);

    Route::get('konversi-alternatif-topsis', [PerhitunganTopsisController::class, 'index']);
    Route::get('hasil-normalisasi-topsis', [PerhitunganTopsisController::class, 'normalisasi']);
    Route::get('hasil-normalisasi-terbobot-topsis', [PerhitunganTopsisController::class, 'hasil_normalisasi_terbobot']);
    Route::get('hasil-solusi-ideal-topsis', [PerhitunganTopsisController::class, 'hasil_solusi_ideal']);

    Route::get('hasil-akhir-topsis', [PerhitunganTopsisController::class, 'hasil_akhir']);
    Route::get('ranking', [RankingController::class, 'index']);
});

//karyawan
Route::middleware(['authKaryawan'])->prefix('karyawan')->group(function () {
    Route::get('/home', [Home::class, 'index']);
    Route::resource('/form-penilaian', PenilaianController::class);


    // Route::resource('/cuti-non-tahunan', Cuti_non::class);

    // Route::get('/cuti-non-tahunan', [Cuti_non::class, 'index'])->name('cuti_non.indexKaryawan');
    // Route::get('/cuti-non-tahunan/create', [Cuti_non::class, 'create'])->name('cuti_non.create');
    // // Route::post('/cuti-non-tahunan', [Cuti_non::class, 'store'])->name('cuti_non.store');
    // Route::get('/cuti-non-tahunan/{id}/edit', [Cuti_non::class, 'edit'])->name('cuti_non.edit');
    // Route::put('/cuti-non-tahunan/{id}', [Cuti_non::class, 'update'])->name('cuti_non.update');
    // Route::delete('/cuti-non-tahunan/{id}', [Cuti_non::class, 'destroy'])->name('cuti_non.destroy');
    // Route::resource('/print-non-tahunan', Print_non_tahunan::class);
    // Route::post('/store-pengajuan-non', [Cuti_non::class, 'store']);
});

// Route::get('/urgensi_cuti_detail/{id}', [Cuti_non::class, 'getUrgensiCuti']);
