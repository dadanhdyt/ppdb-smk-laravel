<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peserta\BiodataController;
use App\Http\Controllers\Peserta\DashboardController;
use App\Http\Controllers\Peserta\DataNilaiRapotController;
use App\Http\Controllers\Peserta\DataOrangTuaController;
use App\Http\Controllers\Peserta\DataPrestasiController;
use App\Http\Controllers\Peserta\PendaftaranController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->name('peserta.')->group(function () {
    Route::get('login', [AuthController::class, 'loginView'])->name('login');
    Route::post('login', [AuthController::class, 'checkLogin'])->name('login.check');
    Route::get('daftar-akun', [AuthController::class, 'daftarView'])->name('daftar');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('peserta.index');
    Route::prefix('dash')->name('peserta.')->group(function () {
        Route::post('pilih_jalur', [PendaftaranController::class, 'pilih_jalur'])->name('pendaftaran.pilih_jalur');
        Route::get('formulir-pendaftaran', [PendaftaranController::class, 'isi_formulir'])->name('pendaftaran.form');

        Route::prefix('form')->name('pendaftaran.form.')->group(function () {
            Route::get('biodata/{id?}', [BiodataController::class, 'index'])->name('biodata');
            Route::put('biodata/{id?}', [BiodataController::class, 'simpan'])->name('biodata.simpan');

            // //data orang tua
            Route::get('orang-tua/{id?}', [DataOrangTuaController::class, 'index'])->name('data-orang-tua');
            Route::put('orang-tua/{id?}', [DataOrangTuaController::class, 'simpan'])->name('data-orang-tua.simpan');
            // data prestasi

            Route::prefix('/prestasi')->group(function () {
                Route::get('/lists', [DataPrestasiController::class, 'lists'])->name('data-prestasi.lists');
                Route::get('/{id?}', [DataPrestasiController::class, 'index'])->name('data-prestasi');
                Route::put('/{id?}/edit', [DataPrestasiController::class, 'simpan'])->name('data-prestasi.simpan');
                Route::delete('/{id?}/delete', [DataPrestasiController::class, 'delete'])->name('data-prestasi.delete');
            });

            Route::prefix('/rapot')->name('data-nilai-rapot.')->group(function () {
                Route::get('/', [DataNilaiRapotController::class, 'index'])->name('index');
                Route::get('/nilai/{semester_id}/{matpel_id?}/{rapot_id?}', [DataNilaiRapotController::class, 'ubah_nilai'])->name('nilai.ubah');
                Route::put('/nilai/{rapot_id?}', [DataNilaiRapotController::class, 'simpan_nilai'])->name('nilai.simpan_nilai');
            });
        });
    });
    Route::prefix('backoffices')->name('backoffice.')->group(function () {
    });
});
