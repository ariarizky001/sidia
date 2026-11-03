@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Edit Rombel</h4>
                    <p class="text-muted small mb-0">Perbarui data rombel</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('rombel.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('rombel.update', $rombel->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Koordinator Wilayah Kecamatan (Unit Kerja Level 2) -->
                        <div class="mb-3">
                            <label for="unit_kerja_parent_id" class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt"></i> Koordinator Wilayah Kecamatan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('unit_kerja_parent_id') is-invalid @enderror" id="unit_kerja_parent_id" name="unit_kerja_parent_id" required onchange="loadSekolah()">
                                <option value="">-- Pilih Koordinator Wilayah --</option>
                                @foreach ($unitKerjaLevel2 as $uk)
                                    <option value="{{ $uk->id }}" {{ $rombel->unit_kerja_parent_id == $uk->id ? 'selected' : '' }}>
                                        {{ $uk->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_kerja_parent_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sekolah Dasar (Unit Kerja Level 3) -->
                        <div class="mb-3">
                            <label for="unit_kerja_id" class="form-label fw-semibold">
                                <i class="fas fa-school"></i> Sekolah Dasar <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('unit_kerja_id') is-invalid @enderror" id="unit_kerja_id" name="unit_kerja_id" required>
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach ($unitKerjaLevel3 as $uk)
                                    <option value="{{ $uk->id }}" data-parent-id="{{ $uk->parent_id }}" {{ $rombel->unit_kerja_id == $uk->id ? 'selected' : '' }}>
                                        {{ $uk->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_kerja_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Rombel -->
                        <div class="mb-3">
                            <label for="nama_rombel" class="form-label fw-semibold">
                                <i class="fas fa-layer-group"></i> Nama Rombel <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_rombel') is-invalid @enderror" id="nama_rombel" name="nama_rombel" placeholder="Contoh: Rombel 1A" value="{{ $rombel->nama_rombel }}" required>
                            @error('nama_rombel')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">
                                <i class="fas fa-note-sticky"></i> Keterangan
                            </label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan (opsional)">{{ $rombel->keterangan }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('rombel.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadSekolah() {
    const parentSelect = document.getElementById('unit_kerja_parent_id');
    const sekolahSelect = document.getElementById('unit_kerja_id');
    const selectedParentId = parentSelect.value;

    // Reset sekolah select
    const options = sekolahSelect.querySelectorAll('option');
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            const parentId = option.getAttribute('data-parent-id');
            option.style.display = (parentId === selectedParentId) ? 'block' : 'none';
        }
    });
}

// Jalankan filter saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('unit_kerja_parent_id').value) {
        loadSekolah();
    }
});
</script>

@endsection
