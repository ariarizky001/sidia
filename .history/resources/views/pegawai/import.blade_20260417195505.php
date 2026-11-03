@extends('layouts.admin')

@section('title', 'Import Data Pegawai')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .form-container { max-width: 900px; margin: 0 auto; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Import Data Pegawai</h4>
                    <p class="text-muted small mb-0">Unggah file Excel untuk mengimport data pegawai</p>
                </div>
                <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="form-container py-3">
        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3"><i class="fas fa-info-circle me-2 text-info"></i> Format File Excel</h5>
                <p class="text-muted small">File Excel Anda harus memiliki kolom-kolom berikut dengan header (CASE SENSITIVE):</p>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Header Excel</th>
                                <th>Wajib</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><code>NIP</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Nomor Induk Pegawai (unik, max 50 karakter)</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><code>NAMA_LENGKAP</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Nama lengkap pegawai (max 100 karakter)</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><code>TGL_LAHIR</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Format: DD-MM-YYYY atau DD/MM/YYYY<br><small class="text-muted">Contoh: 06-02-1969 atau 01/03/1990</small></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><code>Pensiun</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Tanggal pensiun (DD-MM-YYYY atau DD/MM/YYYY)</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><code>BUP</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Batas Usia Pensiun (angka, misal: 58)</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><code>GOL</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Golongan (max 10 karakter)<br><small class="text-muted">Contoh: I/a, II/b, III/d, IV/a, dst</small></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><code>TMT_GOL</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Tanggal Masuk Golongan (DD-MM-YYYY atau DD/MM/YYYY)</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><code>JABATAN</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Nama jabatan (max 100 karakter)</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><code>TMT_JABATAN</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Tanggal Masuk Jabatan (DD-MM-YYYY atau DD/MM/YYYY)</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><code>ESL</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Eselon atau Pendidikan Sebelumnya (max 50 karakter)</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td><code>TMT_CPNS</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Tanggal Masuk CPNS (DD-MM-YYYY atau DD/MM/YYYY)</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td><code>PENDIDIKAN</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Jenjang pendidikan (max 50 karakter)<br><small class="text-muted">Contoh: S1, S2, D3, PASCA SARJANA (S2), dst</small></td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td><code>THN_LULUS</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Tahun lulus (angka, misal: 2010)</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td><code>STATUS_ASN</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Status kepegawaian (max 50 karakter)<br><small class="text-muted">Contoh: PNS, PPPK, dll</small></td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td><code>FORMASI_JABATAN</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Formasi jabatan (max 100 karakter)</td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td><code>UNIT_KERJA_1</code></td>
                                <td><span class="badge bg-danger">Ya</span></td>
                                <td>Unit kerja utama (max 100 karakter)</td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td><code>UNIT_KERJA_2</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Unit kerja kedua (max 100 karakter)</td>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td><code>UNIT_KERJA_3</code></td>
                                <td><span class="badge bg-secondary">Opsional</span></td>
                                <td>Unit kerja ketiga (max 100 karakter)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('pegawai.processImport') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">
                            File Excel <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="fileInput" accept=".xlsx,.xls,.csv" required>
                            <label class="input-group-text" for="fileInput">
                                <i class="fas fa-file-excel"></i>
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Format yang didukung: .xlsx, .xls, .csv | Maksimal: 10MB
                        </small>
                        @error('file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Pastikan data pada file Excel sudah benar sebelum mengimport. Data yang diimport tidak dapat dibatalkan.
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i> Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body p-4">
                <h5 class="mb-3"><i class="fas fa-download me-2 text-success"></i> Template Excel</h5>
                <p class="text-muted">Gunakan template di bawah ini untuk memastikan format file Excel Anda benar:</p>
                <a href="{{ route('pegawai.downloadTemplate') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download me-1"></i> Download Template Excel
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
