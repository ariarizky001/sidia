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
                    <h4 class="fw-bold text-dark mb-0">Edit Status ASN</h4>
                    <p class="text-muted small mb-0">{{ $statusAsn->nama_status }}</p>
                </div>
                <a href="{{ route('status-asn.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="form-container py-3">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('status-asn.update', $statusAsn->id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">
                            Nama Status ASN <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_status" class="form-control @error('nama_status') is-invalid @enderror"
                               value="{{ old('nama_status', $statusAsn->nama_status) }}" placeholder="Contoh: PNS, PPPK, Honorer, Kontrak" required>
                        @error('nama_status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Jelaskan jenis status ASN ini" rows="4">{{ old('deskripsi', $statusAsn->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">— Pilih Status —</option>
                            <option value="aktif" @selected(old('status', $statusAsn->status) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $statusAsn->status) === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('status-asn.index') }}" class="btn btn-outline-secondary">
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
