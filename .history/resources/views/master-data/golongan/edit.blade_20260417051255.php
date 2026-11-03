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
                    <h4 class="fw-bold text-dark mb-0">Edit Golongan</h4>
                    <p class="text-muted small mb-0">{{ $golongan->nama_golongan }}</p>
                </div>
                <a href="{{ route('golongan.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="form-container py-3">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('golongan.update', $golongan->id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    Kode <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                                       value="{{ old('kode', $golongan->kode) }}" placeholder="Contoh: I/a, I/b, II/a" required>
                                @error('kode')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    Urutan <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                                       value="{{ old('urutan', $golongan->urutan) }}" placeholder="Urutan sorting" min="0" required>
                                @error('urutan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">
                            Nama Golongan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_golongan" class="form-control @error('nama_golongan') is-invalid @enderror"
                               value="{{ old('nama_golongan', $golongan->nama_golongan) }}" placeholder="Nama pangkat/golongan" required>
                        @error('nama_golongan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Penjelasan golongan/ruang" rows="4">{{ old('deskripsi', $golongan->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">— Pilih Status —</option>
                            <option value="aktif" @selected(old('status', $golongan->status) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $golongan->status) === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('golongan.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
