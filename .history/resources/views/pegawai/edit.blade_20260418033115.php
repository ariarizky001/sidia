@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .form-container { max-width: 800px; margin: 0 auto; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Edit Data Pegawai</h4>
                    <p class="text-muted small mb-0">{{ $pegawai->nip }} • {{ $pegawai->nama_lengkap }}</p>
                </div>
                <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="form-container py-3">
        <div class="row">
            <div class="col-lg-12">

            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')

                <!-- Section A: Identitas Pegawai -->
                <div class="form-card mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <h2 class="section-title">A. IDENTITAS PEGAWAI</h2>
                        <button type="button" class="btn-menu" title="Menu">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            NIP <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                               value="{{ old('nip', $pegawai->nip) }}" placeholder="18 digit" required>
                        <small class="form-text d-block mt-1">18 digit — tanggal lahir, tahun CPNS, kode instansi</small>
                        @error('nip')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Nama lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                               value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" placeholder="Nama lengkap beserta gelar" required>
                        @error('nama_lengkap')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Tanggal lahir <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                   value="{{ old('tgl_lahir', $pegawai->tgl_lahir) }}" required>
                            @error('tgl_lahir')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status ASN <span class="text-danger">*</span>
                            </label>
                            <select name="status_asn" class="form-select @error('status_asn') is-invalid @enderror" required>
                                <option value="">— Pilih —</option>
                                <option value="PNS" @selected(old('status_asn', $pegawai->status_asn) === 'PNS')>PNS</option>
                                <option value="PPPK" @selected(old('status_asn', $pegawai->status_asn) === 'PPPK')>PPPK</option>
                                <option value="Honorer" @selected(old('status_asn', $pegawai->status_asn) === 'Honorer')>Honorer</option>
                            </select>
                            @error('status_asn')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Section B: Pensiun -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">B. PENSIUN & BATAS USIA PENSIUN</h2>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">BUP (tahun)</label>
                            <select name="bup_tahun" class="form-select @error('bup') is-invalid @enderror">
                                <option value="">— Pilih —</option>
                                <option value="58" @selected(old('bup', $pegawai->bup) === '58')>58 Tahun</option>
                                <option value="60" @selected(old('bup', $pegawai->bup) === '60')>60 Tahun</option>
                                <option value="65" @selected(old('bup', $pegawai->bup) === '65')>65 Tahun</option>
                            </select>
                            <small class="form-text d-block mt-1">Diisi sesuai jenis jabatan</small>
                            @error('bup')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Tanggal pensiun</label>
                            <input type="text" class="form-control" readonly placeholder="Terisi otomatis">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">
                                Status Aktif <span class="text-danger">*</span>
                            </label>
                            <select name="status_aktif" class="form-select @error('status_aktif') is-invalid @enderror" required>
                                <option value="">— Pilih Status —</option>
                                <option value="aktif" @selected(old('status_aktif', $pegawai->status_aktif) === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status_aktif', $pegawai->status_aktif) === 'nonaktif')>Nonaktif</option>
                            </select>
                            @error('status_aktif')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status pensiun</label>
                            <input type="text" class="form-control" readonly placeholder="—">
                        </div>
                    </div>
                </div>

                <!-- Section C: Kepangkatan -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">C. KEPANGKATAN & GOLONGAN</h2>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Golongan / Ruang <span class="text-danger">*</span>
                            </label>
                            <select name="golongan_id" class="form-select @error('golongan_id') is-invalid @enderror" required>
                                <option value="">— Pilih —</option>
                                @foreach($golongans ?? [] as $golongan)
                                    <option value="{{ $golongan->id }}" @selected(old('golongan_id', $pegawai->golongan_id) == $golongan->id)>
                                        {{ $golongan->kode }} - {{ $golongan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('golongan_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                TMT golongan <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tmt_golongan" class="form-control @error('tmt_golongan') is-invalid @enderror"
                                   value="{{ old('tmt_golongan', $pegawai->tmt_golongan) }}" required>
                            <small class="form-text d-block mt-1">Terhitung mulai tanggal kenaikan pangkat</small>
                            @error('tmt_golongan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Section D: Jabatan -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">D. JABATAN</h2>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Nama jabatan <span class="text-danger">*</span>
                            </label>
                            <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" required>
                                <option value="">— Pilih —</option>
                                @foreach($jabatans ?? [] as $jabatan)
                                    <option value="{{ $jabatan->id }}" @selected(old('jabatan_id', $pegawai->jabatan_id) == $jabatan->id)>
                                        {{ $jabatan->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                TMT jabatan <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tmt_jabatan" class="form-control @error('tmt_jabatan') is-invalid @enderror"
                                   value="{{ old('tmt_jabatan', $pegawai->tmt_jabatan) }}" required>
                            @error('tmt_jabatan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Eselon</label>
                            <select name="eselon_id" class="form-select @error('eselon_id') is-invalid @enderror">
                                <option value="">— Pilih —</option>
                                @foreach($eselons ?? [] as $eselon)
                                    <option value="{{ $eselon->id }}" @selected(old('eselon_id', $pegawai->eselon_id) == $eselon->id)>
                                        {{ $eselon->kode }} - {{ $eselon->nama_eselon }}
                                    </option>
                                @endforeach
                            </select>
                            @error('eselon_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Formasi jabatan</label>
                            <select name="formasi_jabatan_id" class="form-select @error('formasi_jabatan_id') is-invalid @enderror">
                                <option value="">— Pilih —</option>
                                @foreach($formasiJabatans ?? [] as $formasi)
                                    <option value="{{ $formasi->id }}" @selected(old('formasi_jabatan_id', $pegawai->formasi_jabatan_id) == $formasi->id)>
                                        {{ $formasi->nama_formasi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('formasi_jabatan_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                TMT CPNS <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tmt_cpns" class="form-control @error('tmt_cpns') is-invalid @enderror"
                                   value="{{ old('tmt_cpns', $pegawai->tmt_cpns) }}" required>
                            @error('tmt_cpns')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Section E: Pendidikan -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">E. PENDIDIKAN</h2>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Jenjang pendidikan <span class="text-danger">*</span>
                            </label>
                            <select name="jenjang_pendidikan_id" class="form-select @error('jenjang_pendidikan_id') is-invalid @enderror" required>
                                <option value="">— Pilih —</option>
                                @foreach($jenjangPendidikans ?? [] as $jenjang)
                                    <option value="{{ $jenjang->id }}" @selected(old('jenjang_pendidikan_id', $pegawai->jenjang_pendidikan_id) == $jenjang->id)>
                                        {{ $jenjang->kode }} - {{ $jenjang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenjang_pendidikan_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun lulus</label>
                            <input type="number" name="thn_lulus" class="form-control"
                                   value="{{ old('thn_lulus', $pegawai->thn_lulus) }}" placeholder="Contoh: 2010" min="1980" max="2100">
                        </div>
                    </div>
                </div>

                <!-- Section F: Unit Kerja -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">F. PENEMPATAN / UNIT KERJA</h2>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">
                                Unit kerja 1 <span class="text-danger">*</span>
                            </label>
                            <select id="unit_kerja_1_id" name="unit_kerja_1_id" class="form-select @error('unit_kerja_1_id') is-invalid @enderror" required>
                                <option value="">— Pilih —</option>
                            </select>
                            @error('unit_kerja_1_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">
                                Unit kerja 2
                            </label>
                            <select id="unit_kerja_2_id" name="unit_kerja_2_id" class="form-select @error('unit_kerja_2_id') is-invalid @enderror" disabled>
                                <option value="">— Pilih Unit Kerja 1 terlebih dahulu —</option>
                            </select>
                            @error('unit_kerja_2_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">
                                Unit kerja 3
                            </label>
                            <select id="unit_kerja_3_id" name="unit_kerja_3_id" class="form-select @error('unit_kerja_3_id') is-invalid @enderror" disabled>
                                <option value="">— Pilih Unit Kerja 2 terlebih dahulu —</option>
                            </select>
                            @error('unit_kerja_3_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="form-actions mb-5">
                    <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="reset" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-redo me-2"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Unit Kerja dropdown with proper hierarchy
    document.addEventListener('DOMContentLoaded', function() {
        const pegawaiUk1Id = {{ $pegawai->unit_kerja_1_id ?? 'null' }};
        const pegawaiUk2Id = {{ $pegawai->unit_kerja_2_id ?? 'null' }};
        const pegawaiUk3Id = {{ $pegawai->unit_kerja_3_id ?? 'null' }};
        
        loadUnitKerjaLevel1();
        
        // If edit mode, load parent dropdowns
        if (pegawaiUk1Id) {
            setTimeout(() => {
                document.getElementById('unit_kerja_1_id').value = pegawaiUk1Id;
                document.getElementById('unit_kerja_1_id').dispatchEvent(new Event('change'));
            }, 300);
        }
        
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
                
                // Restore uk2 value if exists
                if (pegawaiUk2Id && select2.value !== pegawaiUk2Id) {
                    setTimeout(() => {
                        select2.value = pegawaiUk2Id;
                        select2.dispatchEvent(new Event('change'));
                    }, 200);
                }
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
                
                // Restore uk3 value if exists
                if (pegawaiUk3Id && select3.value !== pegawaiUk3Id) {
                    setTimeout(() => {
                        select3.value = pegawaiUk3Id;
                    }, 200);
                }
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
                const currentValue = select.value;
                select.innerHTML = '<option value="">— Pilih —</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.text = item.nama;
                    select.appendChild(option);
                });
                if (currentValue) select.value = currentValue;
            })
            .catch(error => console.error('Error:', error));
    }
    
    function loadUnitKerjaChildren(parentId, selectElement) {
        const currentValue = selectElement.value;
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
                    if (currentValue) selectElement.value = currentValue;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

@endsection
