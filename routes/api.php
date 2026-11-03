<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Route ini tidak memiliki CSRF protection, cocok untuk Postman.
| Semua route di sini otomatis mendapat prefix /api
|
*/

// Bulk insert pegawai via Postman (tanpa auth, tanpa CSRF)
Route::post('/pegawai/bulk', [PegawaiController::class, 'bulkStore']);

// Single insert pegawai via Postman
Route::post('/pegawai', [PegawaiController::class, 'apiStore']);

// Lihat semua data master (untuk referensi ID)
Route::get('/master/golongan', function () {
    return response()->json(\App\Models\Golongan::orderBy('kode')->get(['id', 'kode', 'nama']));
});

Route::get('/master/jabatan', function () {
    return response()->json(\App\Models\Jabatan::where('is_active', true)->orderBy('nama_jabatan')->get(['id', 'nama_jabatan']));
});

Route::get('/master/eselon', function () {
    return response()->json(\App\Models\Eselon::where('status', 'aktif')->orderBy('kode')->get(['id', 'kode', 'nama']));
});

Route::get('/master/jenjang-pendidikan', function () {
    return response()->json(\App\Models\JenjangPendidikan::orderBy('kode')->get(['id', 'kode', 'nama']));
});

Route::get('/master/status-asn', function () {
    return response()->json(\App\Models\StatusAsn::where('aktif', true)->orderBy('nama')->get(['id', 'nama']));
});

Route::get('/master/formasi-jabatan', function () {
    return response()->json(\App\Models\FormasiJabatan::where('is_active', true)->orderBy('nama_formasi')->get(['id', 'nama_formasi']));
});

Route::get('/master/unit-kerja', function () {
    return response()->json(\App\Models\UnitKerja::orderBy('level')->orderBy('nama')->get(['id', 'nama', 'level', 'parent_id']));
});
