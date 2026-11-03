@extends('layouts.admin')

@section('title', 'Import Unit Kerja')

@section('content')

<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="text-dark fw-bold mb-1">Import Unit Kerja dari Excel</h3>
            <p class="text-muted mb-0">Unggah file Excel untuk menambahkan data unit kerja secara massal</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('unit-kerja.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {!! nl2br(session('success')) !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong>
            <pre style="white-space: pre-wrap; margin-top: 10px; margin-bottom: 0; font-size: 0.85rem;">{!! session('error') !!}</pre>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Upload Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload File Excel</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('unit-kerja.processImport') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">Pilih File Excel:</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" 
                                   accept=".xlsx,.xls,.csv" required>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Format: Excel (.xlsx, .xls) atau CSV
                                <br>Ukuran maksimal: 10MB
                            </small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check me-2"></i>Proses Import
                        </button>
                        <a href="{{ route('unit-kerja.downloadTemplate') }}" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-download me-2"></i>Download Template
                        </a>
                    </form>
                </div>
            </div>

            <!-- Format Guide -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>Format File Excel</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-3">File Excel harus memiliki 2 kolom dengan format sebagai berikut:</p>
                    
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Kolom</th>
                                    <th>Nama Header</th>
                                    <th>Deskripsi</th>
                                    <th>Contoh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>1</strong></td>
                                    <td><code>Nama Unit Kerja</code></td>
                                    <td>Nama unit kerja (wajib diisi)</td>
                                    <td>Dinas Pendidikan Dan Kebudayaan</td>
                                </tr>
                                <tr>
                                    <td><strong>2</strong></td>
                                    <td><code>Parent Unit Kerja</code></td>
                                    <td>Nama unit kerja induk (opsional, kosong untuk level 1)</td>
                                    <td>Dinas Pendidikan Dan Kebudayaan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mb-0">
                        <strong><i class="fas fa-lightbulb me-2"></i>Tips:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Baris pertama harus berisi header kolom</li>
                            <li>Pastikan nama unit kerja tidak ada yang duplikat</li>
                            <li>Jika unit kerja memiliki parent, pastikan parent sudah diinput terlebih dahulu di baris atas</li>
                            <li>Level hierarki akan otomatis dihitung berdasarkan parent</li>
                            <li>Untuk unit kerja level 1, kolom Parent Unit Kerja dikosongkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sample Data -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i>Contoh Data</h5>
                </div>
                <div class="card-body p-0">
                    <div style="overflow-x: auto;">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50%;">Nama Unit Kerja</th>
                                    <th style="width: 50%;">Parent Unit Kerja</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.9rem;">
                                <tr>
                                    <td><strong>Dinas Pendidikan Dan Kebudayaan</strong></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td><strong>Bidang Kurikulum</strong></td>
                                    <td>Dinas Pendidikan Dan Kebudayaan</td>
                                </tr>
                                <tr>
                                    <td><strong>Bidang Sarana Prasarana</strong></td>
                                    <td>Dinas Pendidikan Dan Kebudayaan</td>
                                </tr>
                                <tr>
                                    <td><strong>SMA Negeri 1</strong></td>
                                    <td>Bidang Kurikulum</td>
                                </tr>
                                <tr>
                                    <td><strong>SMA Negeri 2</strong></td>
                                    <td>Bidang Sarana Prasarana</td>
                                </tr>
                                <tr>
                                    <td><strong>SMA Negeri 3</strong></td>
                                    <td>Bidang Kurikulum</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge bg-primary">Batas File</span>
                        <span class="ms-2">10 MB</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-primary">Format</span>
                        <span class="ms-2">Excel, CSV</span>
                    </div>
                    <div>
                        <span class="badge bg-primary">Level Max</span>
                        <span class="ms-2">Unlimited</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .table-responsive {
        border-radius: 4px;
    }

    code {
        background-color: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .col-lg-4 {
            margin-top: 20px;
        }
    }
</style>

@endsection
