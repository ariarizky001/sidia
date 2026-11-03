@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary">
                        <h4 class="card-title text-white mb-0">
                            <i class="fas fa-user-tie me-2"></i> Form Data Pegawai / ASN
                        </h4>
                    </div>
                    
                    <form action="{{ route('pegawai.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="card-body">
                            
                            <!-- A. IDENTITAS PEGAWAI -->
                            <div class="section-box mb-4">
                                <h6 class="section-title">A. IDENTITAS PEGAWAI</h6>
                                    <div class="form-group">
                                        <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control @error('nip') is-invalid @enderror"
                                            id="nip"
                                            name="nip"
                                            placeholder="Contoh: 199802030192032004"
                                            value="{{ old('nip') }}"
                                            required
                                        >
                                        @error('nip')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            id="nama_lengkap"
                                            name="nama_lengkap"
                                            placeholder="Tulis lengkap beserta gelar"
                                            value="{{ old('nama_lengkap') }}"
                                            required
                                        >
                                        @error('nama_lengkap')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input
                                            type="date"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                            id="tanggal_lahir"
                                            name="tanggal_lahir"
                                            value="{{ old('tanggal_lahir') }}"
                                            required
                                        >
                                        <small class="form-text ms-1 mt-1 d-block">Format: dd/mm/tttt</small>
                                        @error('tanggal_lahir')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="status_asn" class="form-label">Status ASN <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status_asn') is-invalid @enderror" id="status_asn" name="status_asn" required>
                                            <option value="">— Pilih —</option>
                                            <option value="PNS" {{ old('status_asn') === 'PNS' ? 'selected' : '' }}>PNS</option>
                                            <option value="PPPK" {{ old('status_asn') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                            <option value="Honorer" {{ old('status_asn') === 'Honorer' ? 'selected' : '' }}>Honorer</option>
                                            <option value="Kontrak" {{ old('status_asn') === 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                        </select>
                                        @error('status_asn')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- B. PENDIDIKAN & MATA UJIAN PENDIDIKAN -->
                            <div class="section-divider mb-4 mt-5">
                                <h5 class="fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-graduation-cap me-2"></i> B. PENDIDIKAN & MATA UJIAN PENDIDIKAN
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="bup_jabatan" class="form-label">BUP (Jabatan) <span class="text-danger">*</span></label>
                                        <select class="form-select @error('bup_jabatan') is-invalid @enderror" id="bup_jabatan" name="bup_jabatan" required>
                                            <option value="">— Pilih —</option>
                                            <option value="BP" {{ old('bup_jabatan') === 'BP' ? 'selected' : '' }}>Batas Pensiun</option>
                                        </select>
                                        @error('bup_jabatan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="tanggal_pensiun" class="form-label">Tanggal Pensiun</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="tanggal_pensiun"
                                            name="tanggal_pensiun"
                                            value="Terisi otomatis"
                                            readonly
                                            disabled
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="status_pensiun" class="form-label">Status Pensiun</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="status_pensiun"
                                            name="status_pensiun"
                                            readonly
                                            disabled
                                        >
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="usia_pensiun" class="form-label">Usia Saat Pensiun</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="usia_pensiun"
                                            name="usia_pensiun"
                                            readonly
                                            disabled
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- C. KEPANGKATAN & GOL/ESELON -->
                            <div class="section-divider mb-4 mt-5">
                                <h5 class="fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-sitemap me-2"></i> C. KEPANGKATAN & GOL/ESELON
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="golongan" class="form-label">Golongan (Ruang) <span class="text-danger">*</span></label>
                                        <select class="form-select @error('golongan') is-invalid @enderror" id="golongan" name="golongan" required>
                                            <option value="">— Pilih —</option>
                                            <option value="I/a" {{ old('golongan') === 'I/a' ? 'selected' : '' }}>I/a</option>
                                            <option value="I/b" {{ old('golongan') === 'I/b' ? 'selected' : '' }}>I/b</option>
                                            <option value="I/c" {{ old('golongan') === 'I/c' ? 'selected' : '' }}>I/c</option>
                                            <option value="I/d" {{ old('golongan') === 'I/d' ? 'selected' : '' }}>I/d</option>
                                            <option value="II/a" {{ old('golongan') === 'II/a' ? 'selected' : '' }}>II/a</option>
                                            <option value="II/b" {{ old('golongan') === 'II/b' ? 'selected' : '' }}>II/b</option>
                                            <option value="II/c" {{ old('golongan') === 'II/c' ? 'selected' : '' }}>II/c</option>
                                            <option value="II/d" {{ old('golongan') === 'II/d' ? 'selected' : '' }}>II/d</option>
                                            <option value="III/a" {{ old('golongan') === 'III/a' ? 'selected' : '' }}>III/a</option>
                                            <option value="III/b" {{ old('golongan') === 'III/b' ? 'selected' : '' }}>III/b</option>
                                            <option value="III/c" {{ old('golongan') === 'III/c' ? 'selected' : '' }}>III/c</option>
                                            <option value="III/d" {{ old('golongan') === 'III/d' ? 'selected' : '' }}>III/d</option>
                                            <option value="IV/a" {{ old('golongan') === 'IV/a' ? 'selected' : '' }}>IV/a</option>
                                            <option value="IV/b" {{ old('golongan') === 'IV/b' ? 'selected' : '' }}>IV/b</option>
                                            <option value="IV/c" {{ old('golongan') === 'IV/c' ? 'selected' : '' }}>IV/c</option>
                                            <option value="IV/d" {{ old('golongan') === 'IV/d' ? 'selected' : '' }}>IV/d</option>
                                        </select>
                                        @error('golongan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="tmt_golongan" class="form-label">TMT Golongan <span class="text-danger">*</span></label>
                                        <input
                                            type="date"
                                            class="form-control @error('tmt_golongan') is-invalid @enderror"
                                            id="tmt_golongan"
                                            name="tmt_golongan"
                                            value="{{ old('tmt_golongan') }}"
                                            required
                                        >
                                        <small class="form-text ms-1 mt-1 d-block">Isikan apabila terdapat perubahan kenaikan pangkat</small>
                                        @error('tmt_golongan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- D. JABATAN -->
                            <div class="section-divider mb-4 mt-5">
                                <h5 class="fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-briefcase me-2"></i> D. JABATAN
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control @error('nama_jabatan') is-invalid @enderror"
                                            id="nama_jabatan"
                                            name="nama_jabatan"
                                            placeholder="Contoh: Kapala Seksi Kurikulum dan Penjaminan Mutu SD"
                                            value="{{ old('nama_jabatan') }}"
                                            required
                                        >
                                        @error('nama_jabatan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="tmt_jabatan" class="form-label">TMT Jabatan <span class="text-danger">*</span></label>
                                        <input
                                            type="date"
                                            class="form-control @error('tmt_jabatan') is-invalid @enderror"
                                            id="tmt_jabatan"
                                            name="tmt_jabatan"
                                            value="{{ old('tmt_jabatan') }}"
                                            required
                                        >
                                        @error('tmt_jabatan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="formasi_jabatan" class="form-label">Formasi/Jabatan</label>
                                        <input
                                            type="text"
                                            class="form-control @error('formasi_jabatan') is-invalid @enderror"
                                            id="formasi_jabatan"
                                            name="formasi_jabatan"
                                            placeholder="Contoh: Analis Kepegawaian - Ahli"
                                            value="{{ old('formasi_jabatan') }}"
                                        >
                                        <small class="form-text ms-1 mt-1 d-block">Isikan jabatan saat ini berdasarkan</small>
                                        @error('formasi_jabatan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- E. PENDIDIKAN -->
                            <div class="section-divider mb-4 mt-5">
                                <h5 class="fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-book me-2"></i> E. PENDIDIKAN
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="jenjang_pendidikan" class="form-label">Jenjang Pendidikan <span class="text-danger">*</span></label>
                                        <select class="form-select @error('jenjang_pendidikan') is-invalid @enderror" id="jenjang_pendidikan" name="jenjang_pendidikan" required>
                                            <option value="">— Pilih —</option>
                                            <option value="SD" {{ old('jenjang_pendidikan') === 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                                            <option value="SMP" {{ old('jenjang_pendidikan') === 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                                            <option value="SMA" {{ old('jenjang_pendidikan') === 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                                            <option value="D1" {{ old('jenjang_pendidikan') === 'D1' ? 'selected' : '' }}>D1</option>
                                            <option value="D2" {{ old('jenjang_pendidikan') === 'D2' ? 'selected' : '' }}>D2</option>
                                            <option value="D3" {{ old('jenjang_pendidikan') === 'D3' ? 'selected' : '' }}>D3</option>
                                            <option value="S1" {{ old('jenjang_pendidikan') === 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('jenjang_pendidikan') === 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('jenjang_pendidikan') === 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                        @error('jenjang_pendidikan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                        <input
                                            type="text"
                                            class="form-control @error('tahun_lulus') is-invalid @enderror"
                                            id="tahun_lulus"
                                            name="tahun_lulus"
                                            placeholder="Contoh: 2010"
                                            value="{{ old('tahun_lulus') }}"
                                            inputmode="numeric"
                                        >
                                        @error('tahun_lulus')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- F. PENEMPATAN / UNIT KERJA -->
                            <div class="section-divider mb-4 mt-5">
                                <h5 class="fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-map-marker-alt me-2"></i> F. PENEMPATAN / UNIT KERJA
                                </h5>
                            </div>

                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="unit_kerja_1" class="form-label">Unit Kerja 1 – Induk Dinas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('unit_kerja_1') is-invalid @enderror" id="unit_kerja_1" name="unit_kerja_1" required>
                                        <option value="">— Pilih dinas —</option>
                                        <option value="dinas1" {{ old('unit_kerja_1') === 'dinas1' ? 'selected' : '' }}>Dinas Pendidikan</option>
                                        <option value="dinas2" {{ old('unit_kerja_1') === 'dinas2' ? 'selected' : '' }}>Dinas Kesehatan</option>
                                        <option value="dinas3" {{ old('unit_kerja_1') === 'dinas3' ? 'selected' : '' }}>Dinas Sosial</option>
                                    </select>
                                    @error('unit_kerja_1')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="unit_kerja_2" class="form-label">Unit Kerja 2 – Bidang / Seksi <span class="text-danger">*</span></label>
                                    <select class="form-select @error('unit_kerja_2') is-invalid @enderror" id="unit_kerja_2" name="unit_kerja_2" required>
                                        <option value="">— Pilih bidang —</option>
                                        <option value="bidang1" {{ old('unit_kerja_2') === 'bidang1' ? 'selected' : '' }}>Bidang 1</option>
                                        <option value="bidang2" {{ old('unit_kerja_2') === 'bidang2' ? 'selected' : '' }}>Bidang 2</option>
                                        <option value="bidang3" {{ old('unit_kerja_2') === 'bidang3' ? 'selected' : '' }}>Bidang 3</option>
                                    </select>
                                    @error('unit_kerja_2')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="unit_kerja_3" class="form-label">Unit Kerja 3 – Sub Bidang / Sekolah <span class="text-danger">*</span></label>
                                    <select class="form-select @error('unit_kerja_3') is-invalid @enderror" id="unit_kerja_3" name="unit_kerja_3" required>
                                        <option value="">— Pilih sub bidang —</option>
                                        <option value="subbidang1" {{ old('unit_kerja_3') === 'subbidang1' ? 'selected' : '' }}>Sub Bidang 1</option>
                                        <option value="subbidang2" {{ old('unit_kerja_3') === 'subbidang2' ? 'selected' : '' }}>Sub Bidang 2</option>
                                        <option value="subbidang3" {{ old('unit_kerja_3') === 'subbidang3' ? 'selected' : '' }}>Sub Bidang 3</option>
                                    </select>
                                    @error('unit_kerja_3')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-5">
                                <div class="form-group">
                                    <label for="unit_kerja_4" class="form-label">Unit Kerja 4 – Sub Unit <span class="text-danger">*</span></label>
                                    <select class="form-select @error('unit_kerja_4') is-invalid @enderror" id="unit_kerja_4" name="unit_kerja_4" required>
                                        <option value="">— Pilih unit —</option>
                                        <option value="unit1" {{ old('unit_kerja_4') === 'unit1' ? 'selected' : '' }}>Unit 1</option>
                                        <option value="unit2" {{ old('unit_kerja_4') === 'unit2' ? 'selected' : '' }}>Unit 2</option>
                                        <option value="unit3" {{ old('unit_kerja_4') === 'unit3' ? 'selected' : '' }}>Unit 3</option>
                                    </select>
                                    @error('unit_kerja_4')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="card-footer">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Batal
                                </a>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .section-divider h5 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .card {
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }

        .card-header.bg-primary {
            padding: 1.25rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control[readonly],
        .form-control[disabled],
        input[readonly],
        input[disabled] {
            background-color: #e9ecef !important;
            cursor: not-allowed;
            opacity: 1;
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 1.25rem;
            border-top: 1px solid #dee2e6;
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .gap-2 {
            gap: 0.5rem;
        }
    </style>
@endsection
