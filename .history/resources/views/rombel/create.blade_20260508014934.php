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
                    <h4 class="fw-bold text-dark mb-0">{{ $title }}</h4>
                    <p class="text-muted small mb-0">Tambahkan data rombel baru ke sistem</p>
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
                    <form action="{{ route('rombel.store') }}" method="POST">
                        @csrf

                        <!-- Koordinator Wilayah Kecamatan (Unit Kerja Level 2) -->
                        <div class="mb-3">
                            <label for="unit_kerja_parent_id" class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt"></i> Koordinator Wilayah Kecamatan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('unit_kerja_parent_id') is-invalid @enderror" id="unit_kerja_parent_id" name="unit_kerja_parent_id" required onchange="loadSekolah()">
                                <option value="">-- Pilih Koordinator Wilayah --</option>
                                @foreach ($unitKerjaLevel2 as $uk)
                                    <option value="{{ $uk->id }}" {{ old('unit_kerja_parent_id') == $uk->id ? 'selected' : '' }}>
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
                                    <option value="{{ $uk->id }}" data-parent-id="{{ $uk->parent_id }}" {{ old('unit_kerja_id') == $uk->id ? 'selected' : '' }}>
                                        {{ $uk->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_kerja_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Rombel -->
                        <div class="mb-3">
                            <label for="jumlah_rombel" class="form-label fw-semibold">
                                <i class="fas fa-layer-group"></i> Jumlah Rombel <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control @error('jumlah_rombel') is-invalid @enderror" id="jumlah_rombel" name="jumlah_rombel" placeholder="Contoh: 6" value="{{ old('jumlah_rombel') }}" min="0" required>
                            @error('jumlah_rombel')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">
                                <i class="fas fa-note-sticky"></i> Keterangan
                            </label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Rombel
                            </button>
                            <a href="{{ route('rombel.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="card-title fw-semibold mb-3">
                        <i class="fas fa-info-circle"></i> Panduan
                    </h6>
                    <ul class="small text-muted">
                        <li class="mb-2">
                            <strong>Koordinator Wilayah:</strong> Pilih kecamatan tempat rombel berada
                        </li>
                        <li class="mb-2">
                            <strong>Sekolah Dasar:</strong> Pilih sekolah yang ada di koordinator wilayah yang dipilih
                        </li>
                        <li class="mb-2">
                            <strong>Nama Rombel:</strong> Gunakan format seperti "1A", "2B", "3C", dst
                        </li>
                        <li>
                            <strong>Keterangan:</strong> Tambahkan informasi tambahan jika diperlukan
                        </li>
                    </ul>
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

    // Reset value
    sekolahSelect.value = '';
}

// Jalankan filter saat halaman dimuat jika sudah ada nilai yang dipilih
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('unit_kerja_parent_id').value) {
        loadSekolah();
    }
});
</script>

@endsection
