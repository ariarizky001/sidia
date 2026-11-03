@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .form-container { max-width: 800px; margin: 0 auto; }
    .form-card { margin-bottom: 1.25rem !important; padding: 1.25rem !important; }
    .form-group { margin-bottom: 0.75rem !important; }
    .section-title { margin-bottom: 1rem !important; font-size: 0.85rem !important; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Tambah Data Pegawai</h4>
                    <p class="text-muted small mb-0">Form input data pegawai baru</p>
                </div>
                <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="form-container py-3">

        <form action="{{ route('pegawai.store') }}" method="POST" autocomplete="off">
            @csrf

            <!-- Section A: Identitas Pegawai -->
            <div class="form-card">
                <h2 class="section-title">A. IDENTITAS PEGAWAI</h2>

                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <label class="form-label small fw-semibold">NIP <span class="text-danger">*</span></label>
                        <input type="text" name="nip" class="form-control form-control-sm @error('nip') is-invalid @enderror"
                               value="{{ old('nip') }}" placeholder="18 digit" required>
                        @error('nip')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control form-control-sm @error('nama_lengkap') is-invalid @enderror"
                               value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap" required>
                        @error('nama_lengkap')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_lahir" class="form-control form-control-sm @error('tgl_lahir') is-invalid @enderror"
                               value="{{ old('tgl_lahir') }}" required>
                        @error('tgl_lahir')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Status ASN <span class="text-danger">*</span></label>
                        <select name="status_asn_id" class="form-select form-select-sm @error('status_asn_id') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            @foreach($statusAsns ?? [] as $status)
                                <option value="{{ $status->id }}" @selected(old('status_asn_id') == $status->id)>
                                    {{ $status->kode }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_asn_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Section B: Pensiun & Status Aktif -->
            <div class="form-card">
                <h2 class="section-title">B. PENSIUN & STATUS AKTIF</h2>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">BUP (Tahun)</label>
                        <select name="bup" class="form-select form-select-sm @error('bup') is-invalid @enderror">
                            <option value="">— Pilih —</option>
                            <option value="58" @selected(old('bup') === 58)>58</option>
                            <option value="60" @selected(old('bup') === 60)>60</option>
                            <option value="65" @selected(old('bup') === 65)>65</option>
                        </select>
                        @error('bup')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Status Aktif <span class="text-danger">*</span></label>
                        <select name="status_aktif" class="form-select form-select-sm @error('status_aktif') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            <option value="aktif" @selected(old('status_aktif') === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status_aktif') === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status_aktif')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Section C: Kepangkatan -->
            <div class="form-card">
                <h2 class="section-title">C. KEPANGKATAN</h2>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Golongan <span class="text-danger">*</span></label>
                        <select name="golongan_id" class="form-select form-select-sm @error('golongan_id') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            @foreach($golongans ?? [] as $golongan)
                                <option value="{{ $golongan->id }}" @selected(old('golongan_id') == $golongan->id)>
                                    {{ $golongan->kode }} - {{ $golongan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('golongan_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">TMT Golongan <span class="text-danger">*</span></label>
                        <input type="date" name="tmt_golongan" class="form-control form-control-sm @error('tmt_golongan') is-invalid @enderror"
                               value="{{ old('tmt_golongan') }}" required>
                        @error('tmt_golongan')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Section D: Jabatan -->
            <div class="form-card">
                <h2 class="section-title">D. JABATAN</h2>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Nama Jabatan <span class="text-danger">*</span></label>
                        <select name="jabatan_id" class="form-select form-select-sm @error('jabatan_id') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            @foreach($jabatans ?? [] as $jabatan)
                                <option value="{{ $jabatan->id }}" @selected(old('jabatan_id') == $jabatan->id)>
                                    {{ $jabatan->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jabatan_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">TMT Jabatan <span class="text-danger">*</span></label>
                        <input type="date" name="tmt_jabatan" class="form-control form-control-sm @error('tmt_jabatan') is-invalid @enderror"
                               value="{{ old('tmt_jabatan') }}" required>
                        @error('tmt_jabatan')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Eselon</label>
                        <select name="eselon_id" class="form-select form-select-sm @error('eselon_id') is-invalid @enderror">
                            <option value="">— Pilih —</option>
                            @foreach($eselons ?? [] as $eselon)
                                <option value="{{ $eselon->id }}" @selected(old('eselon_id') == $eselon->id)>
                                    {{ $eselon->kode }} - {{ $eselon->nama_eselon }}
                                </option>
                            @endforeach
                        </select>
                        @error('eselon_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Formasi Jabatan</label>
                        <select name="formasi_jabatan_id" class="form-select form-select-sm @error('formasi_jabatan_id') is-invalid @enderror">
                            <option value="">— Pilih —</option>
                            @foreach($formasiJabatans ?? [] as $formasi)
                                <option value="{{ $formasi->id }}" @selected(old('formasi_jabatan_id') == $formasi->id)>
                                    {{ $formasi->nama_formasi }}
                                </option>
                            @endforeach
                        </select>
                        @error('formasi_jabatan_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">TMT CPNS <span class="text-danger">*</span></label>
                        <input type="date" name="tmt_cpns" class="form-control form-control-sm @error('tmt_cpns') is-invalid @enderror"
                               value="{{ old('tmt_cpns') }}" required>
                        @error('tmt_cpns')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Section E: Pendidikan -->
            <div class="form-card">
                <h2 class="section-title">E. PENDIDIKAN</h2>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Jenjang Pendidikan <span class="text-danger">*</span></label>
                        <select name="jenjang_pendidikan_id" class="form-select form-select-sm @error('jenjang_pendidikan_id') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            @foreach($jenjangPendidikans ?? [] as $jenjang)
                                <option value="{{ $jenjang->id }}" @selected(old('jenjang_pendidikan_id') == $jenjang->id)>
                                    {{ $jenjang->kode }} - {{ $jenjang->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenjang_pendidikan_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Tahun Lulus</label>
                        <input type="number" name="thn_lulus" class="form-control form-control-sm"
                               value="{{ old('thn_lulus') }}" placeholder="2010" min="1980" max="2100">
                    </div>
                </div>
            </div>

            <!-- Section F: Unit Kerja -->
            <div class="form-card">
                <h2 class="section-title">F. UNIT KERJA</h2>

                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <label class="form-label small fw-semibold">Unit Kerja 1 <span class="text-danger">*</span></label>
                        <select id="unit_kerja_1_id" name="unit_kerja_1_id" class="form-select form-select-sm @error('unit_kerja_1_id') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                        </select>
                        @error('unit_kerja_1_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label small fw-semibold">Unit Kerja 2</label>
                        <select id="unit_kerja_2_id" name="unit_kerja_2_id" class="form-select form-select-sm @error('unit_kerja_2_id') is-invalid @enderror" disabled>
                            <option value="">— Pilih Unit Kerja 1 terlebih dahulu —</option>
                        </select>
                        @error('unit_kerja_2_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label small fw-semibold">Unit Kerja 3</label>
                        <select id="unit_kerja_3_id" name="unit_kerja_3_id" class="form-select form-select-sm @error('unit_kerja_3_id') is-invalid @enderror" disabled>
                            <option value="">— Pilih Unit Kerja 2 terlebih dahulu —</option>
                        </select>
                        @error('unit_kerja_3_id')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="reset" class="btn btn-sm btn-outline-secondary flex-grow-1">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>

        </form>
    </div>
</div>

</div>

<script>
    // Initialize Unit Kerja 1 dropdown with level 1 items
    document.addEventListener('DOMContentLoaded', function() {
        loadUnitKerjaLevel1();

        // Unit Kerja 1 change event
        document.getElementById('unit_kerja_1_id').addEventListener('change', function() {
            const parentId = this.value;
            const select2 = document.getElementById('unit_kerja_2_id');
            const select3 = document.getElementById('unit_kerja_3_id');

            select3.innerHTML = '<option value="">— Pilih Unit Kerja 2 terlebih dahulu —</option>';
            select3.disabled = true;

            if (parentId) {
                loadUnitKerjaChildren(parentId, select2);
                select2.disabled = false;
            } else {
                select2.innerHTML = '<option value="">— Pilih Unit Kerja 1 terlebih dahulu —</option>';
                select2.disabled = true;
            }
        });

        // Unit Kerja 2 change event
        document.getElementById('unit_kerja_2_id').addEventListener('change', function() {
            const parentId = this.value;
            const select3 = document.getElementById('unit_kerja_3_id');

            if (parentId) {
                loadUnitKerjaChildren(parentId, select3);
                select3.disabled = false;
            } else {
                select3.innerHTML = '<option value="">— Pilih Unit Kerja 2 terlebih dahulu —</option>';
                select3.disabled = true;
            }
        });
    });

    function loadUnitKerjaLevel1() {
        fetch('/api/pegawai/unit-kerja/level1')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('unit_kerja_1_id');
                select.innerHTML = '<option value="">— Pilih —</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.text = item.nama;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function loadUnitKerjaChildren(parentId, selectElement) {
        fetch(`/api/pegawai/unit-kerja/children/${parentId}`)
            .then(response => response.json())
            .then(data => {
                selectElement.innerHTML = '<option value="">— Pilih —</option>';
                if (data.length === 0) {
                    selectElement.innerHTML += '<option disabled>Tidak ada data</option>';
                    selectElement.disabled = true;
                } else {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.text = item.nama;
                        selectElement.appendChild(option);
                    });
                    selectElement.disabled = false;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

@endsection
