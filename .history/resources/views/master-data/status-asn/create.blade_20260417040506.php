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
                    <h4 class="fw-bold text-dark mb-0">Tambah Status ASN</h4>
                    <p class="text-muted small mb-0">Tambahkan status ASN baru (PNS, PPPK, Honorer, dll)</p>
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
                <form action="{{ route('status-asn.store') }}" method="POST" autocomplete="off">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">
                            Nama <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" placeholder="Contoh: Pegawai Negeri Sipil" required>
                        @error('nama')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Kode</label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                               value="{{ old('kode') }}" placeholder="Contoh: PNS, PPPK, HON">
                        @error('kode')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" 
                                   @checked(old('aktif', true)) style="width: 3rem; height: 1.5rem;">
                            <label class="form-check-label fw-semibold" for="aktif">
                                Aktif
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">Centang untuk mengaktifkan status ini</small>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('status-asn.index') }}" class="btn btn-outline-secondary">
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

