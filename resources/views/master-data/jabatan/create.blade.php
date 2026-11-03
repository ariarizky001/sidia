@extends('layouts.admin')

@section('title', 'Tambah Jabatan')

@section('content')

<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="text-dark fw-bold mb-1">Tambah Jabatan</h3>
            <p class="text-muted mb-0">Form untuk menambah data jabatan baru</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('jabatan.store') }}" method="POST">
                        @csrf

                        <!-- Nama Jabatan -->
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label fw-bold">Nama Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control @error('nama_jabatan') is-invalid @enderror"
                                   placeholder="Contoh: Kepala Dinas, Kepala Bidang" value="{{ old('nama_jabatan') }}" required>
                            @error('nama_jabatan')
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
                                <br>• <strong>Non-Struktural:</strong> Jabatan di luar struktur resmi
                            </small>
                        </div>

                        <!-- Eselon -->
                        <div class="mb-3">
                            <label for="eselon_id" class="form-label fw-bold">Eselon <span class="text-secondary">(Opsional)</span></label>
                            <select name="eselon_id" id="eselon_id" class="form-select @error('eselon_id') is-invalid @enderror">
                                <option value="">-- Pilih Eselon --</option>
                                @foreach ($eselons as $eselon)
                                    <option value="{{ $eselon->id }}" {{ old('eselon_id') == $eselon->id ? 'selected' : '' }}>
                                        {{ $eselon->nama_eselon }} ({{ $eselon->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('eselon_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent Jabatan -->
                        <div class="mb-3">
                            <label for="parent_id" class="form-label fw-bold">Parent Jabatan <span class="text-secondary">(Opsional)</span></label>
                            <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- Pilih Parent Jabatan --</option>
                                @foreach ($parentJabatans as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Pilih jabatan induk jika jabatan ini merupakan jabatan anak
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
                            <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">
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
                        <li><strong>Nama:</strong> Nama jabatan yang jelas dan unik</li>
                        <li><strong>Jenis:</strong> Kategori jenis jabatan</li>
                        <li><strong>Eselon:</strong> Tingkat eselon (opsional)</li>
                        <li><strong>Parent:</strong> Untuk membuat hierarki</li>
                        <li><strong>Status:</strong> Tentukan keaktifan jabatan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
