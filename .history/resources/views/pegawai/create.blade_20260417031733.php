@extends('layouts.admin')

@section('content')

<style>
    .form-container { max-width: 800px; margin: 0 auto; }
    .form-card { margin-bottom: 1.25rem !important; padding: 1.25rem !important; }
    .form-group { margin-bottom: 0.75rem !important; }
    .section-title { margin-bottom: 1rem !important; font-size: 0.85rem !important; }
</style>

<div class="container-fluid py-3">
    <div class="form-container">

        <!-- Header -->
        <div class="mb-3">
            <h1 class="h4 fw-bold text-dark mb-1">Tambah Data Pegawai</h1>
            <p class="text-muted small">Isi form berikut untuk menambahkan pegawai baru</p>
        </div>

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
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_lahir" class="form-control form-control-sm @error('tgl_lahir') is-invalid @enderror"
                               value="{{ old('tgl_lahir') }}" required>
                        @error('tgl_lahir')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Status ASN <span class="text-danger">*</span></label>
                        <select name="status_asn" class="form-select form-select-sm @error('status_asn') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            <option value="PNS" @selected(old('status_asn') === 'PNS')>PNS</option>
                            <option value="PPPK" @selected(old('status_asn') === 'PPPK')>PPPK</option>
                            <option value="Honorer" @selected(old('status_asn') === 'Honorer')>Honorer</option>
                        </select>
                        @error('status_asn')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
                </div>

                <!-- Section B: Pensiun -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">B. PENSIUN & BATAS USIA PENSIUN</h2>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">BUP (tahun)</label>
                            <select name="bup_tahun" class="form-select @error('bup_tahun') is-invalid @enderror">
                                <option value="">— Pilih —</option>
                                <option value="58" @selected(old('bup_tahun') === '58')>58 Tahun</option>
                                <option value="60" @selected(old('bup_tahun') === '60')>60 Tahun</option>
                                <option value="65" @selected(old('bup_tahun') === '65')>65 Tahun</option>
                            </select>
                            <small class="form-text d-block mt-1">Diisi sesuai jenis jabatan</small>
                            @error('bup_tahun')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
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
                                <option value="aktif" @selected(old('status_aktif') === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status_aktif') === 'nonaktif')>Nonaktif</option>
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
                            <select name="golongan" class="form-select @error('golongan') is-invalid @enderror" required>
                                <option value="">— Pilih —</option>
                                <option value="I/a" @selected(old('golongan') === 'I/a')>I/a</option>
                                <option value="I/b" @selected(old('golongan') === 'I/b')>I/b</option>
                                <option value="I/c" @selected(old('golongan') === 'I/c')>I/c</option>
                                <option value="I/d" @selected(old('golongan') === 'I/d')>I/d</option>
                                <option value="II/a" @selected(old('golongan') === 'II/a')>II/a</option>
                                <option value="II/b" @selected(old('golongan') === 'II/b')>II/b</option>
                                <option value="II/c" @selected(old('golongan') === 'II/c')>II/c</option>
                                <option value="II/d" @selected(old('golongan') === 'II/d')>II/d</option>
                                <option value="III/a" @selected(old('golongan') === 'III/a')>III/a</option>
                                <option value="III/b" @selected(old('golongan') === 'III/b')>III/b</option>
                                <option value="III/c" @selected(old('golongan') === 'III/c')>III/c</option>
                                <option value="III/d" @selected(old('golongan') === 'III/d')>III/d</option>
                                <option value="IV/a" @selected(old('golongan') === 'IV/a')>IV/a</option>
                                <option value="IV/b" @selected(old('golongan') === 'IV/b')>IV/b</option>
                                <option value="IV/c" @selected(old('golongan') === 'IV/c')>IV/c</option>
                                <option value="IV/d" @selected(old('golongan') === 'IV/d')>IV/d</option>
                            </select>
                            @error('golongan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                TMT golongan <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tmt_golongan" class="form-control @error('tmt_golongan') is-invalid @enderror"
                                   value="{{ old('tmt_golongan') }}" required>
                            <small class="form-text d-block mt-1">Terhitung mulai tanggal kenaikan pangkat</small>
                            @error('tmt_golongan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Section D: Jabatan -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">D. JABATAN</h2>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Nama jabatan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_jabatan" class="form-control @error('nama_jabatan') is-invalid @enderror"
                               value="{{ old('nama_jabatan') }}" placeholder="Contoh: Kepala Seksi Kurikulum" required>
                        @error('nama_jabatan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                TMT jabatan <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tmt_jabatan" class="form-control @error('tmt_jabatan') is-invalid @enderror"
                                   value="{{ old('tmt_jabatan') }}" required>
                            @error('tmt_jabatan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Formasi jabatan</label>
                            <input type="text" name="formasi_jabatan" class="form-control"
                                   value="{{ old('formasi_jabatan') }}" placeholder="Contoh: Analis Kepegawaian - Ahli">
                            <small class="form-text d-block mt-1">Kosongkan jika belum ada formasi</small>
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
                            <select name="jenjang_pendidikan" class="form-select @error('jenjang_pendidikan') is-invalid @enderror" required>
                                <option value="">— Pilih —</option>
                                <option value="S3" @selected(old('jenjang_pendidikan') === 'S3')>S3 / Doktoral</option>
                                <option value="S2" @selected(old('jenjang_pendidikan') === 'S2')>S2 / Magister</option>
                                <option value="S1" @selected(old('jenjang_pendidikan') === 'S1')>S1 / Sarjana</option>
                                <option value="D3" @selected(old('jenjang_pendidikan') === 'D3')>D3 / Diploma</option>
                                <option value="SMA" @selected(old('jenjang_pendidikan') === 'SMA')>SMA / SMK</option>
                                <option value="SMP" @selected(old('jenjang_pendidikan') === 'SMP')>SMP</option>
                                <option value="SD" @selected(old('jenjang_pendidikan') === 'SD')>SD</option>
                            </select>
                            @error('jenjang_pendidikan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun lulus</label>
                            <input type="number" name="tahun_lulus" class="form-control"
                                   value="{{ old('tahun_lulus') }}" placeholder="Contoh: 2010" min="1980" max="2100">
                        </div>
                    </div>
                </div>

                <!-- Section F: Unit Kerja -->
                <div class="form-card mb-4">
                    <h2 class="section-title mb-4">F. PENEMPATAN / UNIT KERJA</h2>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Unit kerja 1 — Induk Dinas <span class="text-danger">*</span>
                        </label>
                        <select name="unit_kerja_satu" class="form-select @error('unit_kerja_satu') is-invalid @enderror" required>
                            <option value="">— Pilih dinas —</option>
                            <option value="Dinas Pendidikan" @selected(old('unit_kerja_satu') === 'Dinas Pendidikan')>Dinas Pendidikan</option>
                            <option value="Dinas Kesehatan" @selected(old('unit_kerja_satu') === 'Dinas Kesehatan')>Dinas Kesehatan</option>
                        </select>
                        @error('unit_kerja_satu')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Unit kerja 2 — Bidang / Satuan <span class="text-danger">*</span>
                        </label>
                        <select name="unit_kerja_2" class="form-select @error('unit_kerja_2') is-invalid @enderror" required>
                            <option value="">— Pilih bidang —</option>
                            <option value="Bidang 1" @selected(old('unit_kerja_2') === 'Bidang 1')>Bidang 1</option>
                            <option value="Bidang 2" @selected(old('unit_kerja_2') === 'Bidang 2')>Bidang 2</option>
                        </select>
                        @error('unit_kerja_2')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Unit kerja 3 — Sub Bagian / Sekolah</label>
                        <select name="unit_kerja_3" class="form-select">
                            <option value="">— Pilih unit —</option>
                            <option value="Sub 1" @selected(old('unit_kerja_3') === 'Sub 1')>Sub 1</option>
                            <option value="Sub 2" @selected(old('unit_kerja_3') === 'Sub 2')>Sub 2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Unit kerja 4</label>
                        <select name="unit_kerja_4" class="form-select">
                            <option value="">— Pilih unit —</option>
                            <option value="Unit 1" @selected(old('unit_kerja_4') === 'Unit 1')>Unit 1</option>
                            <option value="Unit 2" @selected(old('unit_kerja_4') === 'Unit 2')>Unit 2</option>
                        </select>
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
                        <i class="fas fa-save me-2"></i> Simpan Seluruh Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
