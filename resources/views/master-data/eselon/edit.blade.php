@extends('layouts.admin')

@section('title', 'Edit Eselon')

@section('content')

<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="text-dark fw-bold mb-1">Edit Eselon</h3>
            <p class="text-muted mb-0">Form untuk mengubah data eselon</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('eselon.update', $eselon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Kode -->
                        <div class="mb-3">
                            <label for="kode" class="form-label fw-bold">Kode Eselon <span class="text-danger">*</span></label>
                            <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror"
                                   value="{{ old('kode', $eselon->kode) }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Eselon -->
                        <div class="mb-3">
                            <label for="nama_eselon" class="form-label fw-bold">Nama Eselon <span class="text-danger">*</span></label>
                            <input type="text" name="nama_eselon" id="nama_eselon" class="form-control @error('nama_eselon') is-invalid @enderror"
                                   value="{{ old('nama_eselon', $eselon->nama_eselon) }}" required>
                            @error('nama_eselon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="4">{{ old('deskripsi', $eselon->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                Maksimal 500 karakter
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif" {{ old('status', $eselon->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $eselon->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('eselon.index') }}" class="btn btn-secondary">
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
                            <strong>{{ $eselon->created_at->format('d M Y, H:i') }}</strong>
                        </div>
                        <div>
                            <span class="text-muted">Diubah:</span><br>
                            <strong>{{ $eselon->updated_at->format('d M Y, H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
