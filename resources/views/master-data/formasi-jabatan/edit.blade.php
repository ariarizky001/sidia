@extends('layouts.admin')

@section('title', 'Edit Formasi Jabatan')

@section('content')

<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="text-dark fw-bold mb-1">Edit Formasi Jabatan</h3>
            <p class="text-muted mb-0">Form untuk mengubah data formasi jabatan</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('formasi-jabatan.update', $formasiJabatan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Formasi -->
                        <div class="mb-3">
                            <label for="nama_formasi" class="form-label fw-bold">Nama Formasi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_formasi" id="nama_formasi" class="form-control @error('nama_formasi') is-invalid @enderror"
                                   value="{{ old('nama_formasi', $formasiJabatan->nama_formasi) }}" required>
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
                                    <option value="{{ $jenis }}" {{ old('jenis_jabatan', $formasiJabatan->jenis_jabatan) === $jenis ? 'selected' : '' }}>
                                        {{ ucfirst($jenis) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="kategori" class="form-label fw-bold">Kategori <span class="text-secondary">(Opsional)</span></label>
                            <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror"
                                   value="{{ old('kategori', $formasiJabatan->kategori) }}">
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="is_active" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="is_active" id="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="true" {{ old('is_active', $formasiJabatan->is_active) === 'true' || old('is_active', $formasiJabatan->is_active) === 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="false" {{ old('is_active', $formasiJabatan->is_active) === 'false' || old('is_active', $formasiJabatan->is_active) === 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
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
                        <i class="fas fa-info-circle text-info me-2"></i>Informasi Data
                    </h6>
                    <div class="small mb-0" style="line-height: 1.8;">
                        <div class="mb-2">
                            <span class="text-muted">Dibuat:</span><br>
                            <strong>{{ optional($formasiJabatan->created_at)->format('d M Y, H:i') ?? '-' }}</strong>
                        </div>
                        <div>
                            <span class="text-muted">Diubah:</span><br>
                            <strong>{{ optional($formasiJabatan->updated_at)->format('d M Y, H:i') ?? '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
