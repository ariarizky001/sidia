@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .form-container { max-width: 600px; margin: 0 auto; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Tambah Unit Kerja</h4>
                    <p class="text-muted small mb-0">Tambahkan unit kerja/dinas baru</p>
                </div>
                <a href="{{ route('unit-kerja.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="form-container py-3">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('unit-kerja.store') }}" method="POST" autocomplete="off">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">
                            Nama Unit <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_unit" class="form-control @error('nama_unit') is-invalid @enderror"
                               value="{{ old('nama_unit') }}" placeholder="Contoh: Dinas Pendidikan, Kantor Kesehatan" required>
                        @error('nama_unit')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Penjelasan unit kerja" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">— Pilih Status —</option>
                            <option value="aktif" @selected(old('status') === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('unit-kerja.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
