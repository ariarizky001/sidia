@extends('layouts.admin')

@section('title', 'Tambah Formasi Jabatan')

@section('content')

<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="text-dark fw-bold mb-1">Tambah Formasi Jabatan</h3>
            <p class="text-muted mb-0">Form untuk menambah data formasi jabatan baru</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('formasi-jabatan.store') }}" method="POST">
                        @csrf

                        <!-- Nama Formasi -->
                        <div class="mb-3">
                            <label for="nama_formasi" class="form-label fw-bold">Nama Formasi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_formasi" id="nama_formasi" class="form-control @error('nama_formasi') is-invalid @enderror"
                                   placeholder="Contoh: Formasi Kepala Dinas" value="{{ old('nama_formasi') }}" required>
                            @error('nama_formasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Jabatan -->
                        <div class="mb-3">
                            <label for="jenis_jabatan" class="form-label fw-bold">Jenis Jabatan <span class="text-danger">*</span></label>
                            <select name="jenis_jabatan" id="jenis_jabatan" class="form-select @error('jenis_jabatan') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Jabatan --</option>
                                @foreach ($jenisJabatan as $jenis)
                                    <option value="{{ $jenis }}" {{ old('jenis_jabatan') === $jenis ? 'selected' : '' }}>
                                        {{ ucfirst($jenis) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                • <strong>Struktural:</strong> Jabatan dalam struktur organisasi
                                <br>• <strong>Fungsional:</strong> Jabatan berdasarkan fungsi kerja
                            </small>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="kategori" class="form-label fw-bold">Kategori <span class="text-secondary">(Opsional)</span></label>
                            <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror"
                                   placeholder="Contoh: Pimpinan, Pelaksana, Staf" value="{{ old('kategori') }}">
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Kategori untuk pengelompokan formasi jabatan
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="is_active" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="is_active" id="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="true" {{ old('is_active') === 'true' || old('is_active') === true ? 'selected' : '' }}>Aktif</option>
                                <option value="false" {{ old('is_active') === 'false' || old('is_active') === false ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('formasi-jabatan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="fas fa-lightbulb text-warning me-2"></i>Tips Pengisian
                    </h6>
                    <ul class="small mb-0" style="line-height: 1.8;">
                        <li><strong>Nama:</strong> Nama formasi jabatan yang jelas</li>
                        <li><strong>Jenis:</strong> Struktural atau Fungsional</li>
                        <li><strong>Kategori:</strong> Pengelompokan jabatan</li>
                        <li><strong>Status:</strong> Aktif atau Nonaktif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
