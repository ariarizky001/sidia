<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Data Pegawai
    Route::resource('pegawai', App\Http\Controllers\PegawaiController::class);
    Route::get('/pegawai/import/form', [App\Http\Controllers\PegawaiController::class, 'importForm'])->name('pegawai.importForm');
    Route::post('/pegawai/import/process', [App\Http\Controllers\PegawaiController::class, 'processImport'])->name('pegawai.processImport');
    Route::get('/pegawai/import/template', [App\Http\Controllers\PegawaiController::class, 'downloadTemplate'])->name('pegawai.downloadTemplate');
    Route::get('/pegawai/status/pns', [App\Http\Controllers\PegawaiController::class, 'pns'])->name('pegawai.pns');
    Route::get('/pegawai/status/pppk', [App\Http\Controllers\PegawaiController::class, 'pppk'])->name('pegawai.pppk');

    // API Routes untuk Pegawai Unit Kerja Dropdown
    Route::prefix('api/pegawai')->group(function () {
        Route::get('/unit-kerja/level1', [App\Http\Controllers\PegawaiController::class, 'getUnitKerjaLevel1']);
        Route::get('/unit-kerja/children/{parentId}', [App\Http\Controllers\PegawaiController::class, 'getUnitKerjaChildren']);
    });

    // Route untuk Mapping - Rombel
    Route::resource('rombel', App\Http\Controllers\RombelController::class);
    Route::post('/rombel/store-inline', [App\Http\Controllers\RombelController::class, 'storeInline'])->name('rombel.store-inline');
    Route::patch('/rombel/{id}/update-inline', [App\Http\Controllers\RombelController::class, 'updateInline'])->name('rombel.update-inline');

    // Route untuk Mapping - Kebutuhan Guru
    Route::resource('kebutuhan-guru', App\Http\Controllers\KebutuhanGuruController::class, [
        'parameters' => ['kebutuhan_guru' => 'id']
    ]);

    // Route untuk Master Data
    Route::resource('status-asn', App\Http\Controllers\StatusAsnController::class, [
        'parameters' => ['status_asn' => 'statusAsn']
    ]);
    Route::resource('golongan', App\Http\Controllers\GolonganController::class);
    Route::resource('eselon', App\Http\Controllers\EselonController::class);
    Route::resource('jabatan', App\Http\Controllers\JabatanController::class);
    Route::resource('formasi-jabatan', App\Http\Controllers\FormasiJabatanController::class, [
        'parameters' => ['formasi_jabatan' => 'formasiJabatan']
    ]);
    Route::resource('jenjang-pendidikan', App\Http\Controllers\JenjangPendidikanController::class, [
        'parameters' => ['jenjang_pendidikan' => 'jenjangPendidikan']
    ]);
    Route::resource('unit-kerja', App\Http\Controllers\UnitKerjaController::class, [
        'parameters' => ['unit_kerja' => 'unitKerja']
    ]);
    Route::get('/unit-kerja/import/form', [App\Http\Controllers\UnitKerjaController::class, 'importForm'])->name('unit-kerja.importForm');
    Route::post('/unit-kerja/import/process', [App\Http\Controllers\UnitKerjaController::class, 'processImport'])->name('unit-kerja.processImport');
    Route::get('/unit-kerja/import/template', [App\Http\Controllers\UnitKerjaController::class, 'downloadTemplate'])->name('unit-kerja.downloadTemplate');

    // API Routes untuk Unit Kerja Dropdown
    Route::prefix('api/unit-kerja')->group(function () {
        Route::get('/parents', [App\Http\Controllers\UnitKerjaController::class, 'getParentsByLevel']);
        Route::get('/children/{parentId}/{level}', [App\Http\Controllers\UnitKerjaController::class, 'getChildrenByParent']);
    });
});

require __DIR__.'/auth.php';
