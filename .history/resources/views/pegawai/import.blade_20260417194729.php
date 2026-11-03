@extends('layouts.admin')

@section('title', 'Import Data Pegawai')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .form-container { max-width: 700px; margin: 0 auto; }
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

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-info-circle me-2 text-info"></i> Format File Excel</h5>
                        <p class="text-muted small">File Excel Anda harus memiliki kolom-kolom berikut dengan header:</p>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kolom</th>
                                        <th>Wajib</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><code>nip</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Nomor Induk Pegawai (unik)</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><code>nama_lengkap</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Nama lengkap pegawai</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><code>tgl_lahir</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Format: YYYY-MM-DD, DD-MM-YYYY, atau DD/MM/YYYY<br><small class="text-muted">Contoh: 1990-05-15 atau 16-01-1984 atau 01/02/1990</small></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><code>golongan</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Contoh: I/a, II/b, III/c, dst</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><code>jabatan</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Jabatan pegawai</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td><code>pendidikan</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Jenjang pendidikan (S1, S2, D3, dst)</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td><code>status_asn</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Status kepegawaian</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td><code>unit_kerja_satu</code></td>
                                        <td><span class="badge bg-danger">Ya</span></td>
                                        <td>Unit kerja utama</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td><code>pensiun</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Tanggal pensiun<br><small class="text-muted">Format: YYYY-MM-DD, DD-MM-YYYY, atau DD/MM/YYYY</small></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td><code>bup</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Batas usia pensiun<br><small class="text-muted">Format: YYYY-MM-DD, DD-MM-YYYY, atau DD/MM/YYYY</small></td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td><code>tmt_golongan</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Tanggal masuk golongan (YYYY-MM-DD)</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td><code>tmt_jabatan</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Tanggal masuk jabatan (YYYY-MM-DD)</td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td><code>thn_lulus</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Tahun lulus (angka, misal: 2010)</td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td><code>formasi_jabatan</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Formasi jabatan</td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td><code>unit_kerja_2</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Unit kerja kedua</td>
                                    </tr>
                                    <tr>
                                        <td>16</td>
                                        <td><code>unit_kerja_3</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Unit kerja ketiga</td>
                                    </tr>
                                    <tr>
                                        <td>17</td>
                                        <td><code>status_aktif</code></td>
                                        <td><span class="badge bg-secondary">Opsional</span></td>
                                        <td>Status aktif (default: aktif)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>

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
