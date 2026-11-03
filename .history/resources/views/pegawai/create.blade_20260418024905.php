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

            <!-- Section B: Pensiun & Status Aktif -->
            <div class="form-card">
                <h2 class="section-title">B. PENSIUN & STATUS AKTIF</h2>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">BUP (Tahun)</label>
                        <select name="bup_tahun" class="form-select form-select-sm @error('bup_tahun') is-invalid @enderror">
                            <option value="">— Pilih —</option>
                            <option value="58" @selected(old('bup_tahun') === '58')>58</option>
                            <option value="60" @selected(old('bup_tahun') === '60')>60</option>
                            <option value="65" @selected(old('bup_tahun') === '65')>65</option>
                        </select>
                        @error('bup_tahun')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
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
                        <select name="golongan" class="form-select form-select-sm @error('golongan') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            <optgroup label="Golongan I">
                                <option value="I/a" @selected(old('golongan') === 'I/a')>I/a</option>
                                <option value="I/b" @selected(old('golongan') === 'I/b')>I/b</option>
                                <option value="I/c" @selected(old('golongan') === 'I/c')>I/c</option>
                                <option value="I/d" @selected(old('golongan') === 'I/d')>I/d</option>
                            </optgroup>
                            <optgroup label="Golongan II">
                                <option value="II/a" @selected(old('golongan') === 'II/a')>II/a</option>
                                <option value="II/b" @selected(old('golongan') === 'II/b')>II/b</option>
                                <option value="II/c" @selected(old('golongan') === 'II/c')>II/c</option>
                                <option value="II/d" @selected(old('golongan') === 'II/d')>II/d</option>
                            </optgroup>
                            <optgroup label="Golongan III">
                                <option value="III/a" @selected(old('golongan') === 'III/a')>III/a</option>
                                <option value="III/b" @selected(old('golongan') === 'III/b')>III/b</option>
                                <option value="III/c" @selected(old('golongan') === 'III/c')>III/c</option>
                                <option value="III/d" @selected(old('golongan') === 'III/d')>III/d</option>
                            </optgroup>
                            <optgroup label="Golongan IV">
                                <option value="IV/a" @selected(old('golongan') === 'IV/a')>IV/a</option>
                                <option value="IV/b" @selected(old('golongan') === 'IV/b')>IV/b</option>
                                <option value="IV/c" @selected(old('golongan') === 'IV/c')>IV/c</option>
                                <option value="IV/d" @selected(old('golongan') === 'IV/d')>IV/d</option>
                            </optgroup>
                        </select>
                        @error('golongan')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
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
                    <div class="col-12 mb-2">
                        <label class="form-label small fw-semibold">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control form-control-sm @error('jabatan') is-invalid @enderror"
                               value="{{ old('jabatan') }}" placeholder="Jabatan" required>
                        @error('jabatan')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
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
                        <label class="form-label small fw-semibold">TMT Jabatan <span class="text-danger">*</span></label>
                        <input type="date" name="tmt_jabatan" class="form-control form-control-sm @error('tmt_jabatan') is-invalid @enderror"
                               value="{{ old('tmt_jabatan') }}" required>
                        @error('tmt_jabatan')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Formasi Jabatan</label>
                        <input type="text" name="formasi_jabatan" class="form-control form-control-sm"
                               value="{{ old('formasi_jabatan') }}" placeholder="Opsional">
                    </div>
                </div>
            </div>

            <!-- Section E: Pendidikan -->
            <div class="form-card">
                <h2 class="section-title">E. PENDIDIKAN</h2>

                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Jenjang Pendidikan <span class="text-danger">*</span></label>
                        <select name="pendidikan" class="form-select form-select-sm @error('pendidikan') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            <option value="S3" @selected(old('pendidikan') === 'S3')>S3 / Doktor</option>
                            <option value="S2" @selected(old('pendidikan') === 'S2')>S2 / Magister</option>
                            <option value="S1" @selected(old('pendidikan') === 'S1')>S1 / Sarjana</option>
                            <option value="D3" @selected(old('pendidikan') === 'D3')>D3 / Diploma</option>
                            <option value="SMA" @selected(old('pendidikan') === 'SMA')>SMA / SMK</option>
                            <option value="SMP" @selected(old('pendidikan') === 'SMP')>SMP</option>
                            <option value="SD" @selected(old('pendidikan') === 'SD')>SD</option>
                        </select>
                        @error('pendidikan')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
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
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Unit Kerja 1 <span class="text-danger">*</span></label>
                        <select name="unit_kerja_satu" class="form-select form-select-sm @error('unit_kerja_satu') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            <option value="Dinas Pendidikan" @selected(old('unit_kerja_satu') === 'Dinas Pendidikan')>Dinas Pendidikan</option>
                            <option value="Dinas Kesehatan" @selected(old('unit_kerja_satu') === 'Dinas Kesehatan')>Dinas Kesehatan</option>
                        </select>
                        @error('unit_kerja_satu')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Unit Kerja 2 <span class="text-danger">*</span></label>
                        <select name="unit_kerja_2" class="form-select form-select-sm @error('unit_kerja_2') is-invalid @enderror" required>
                            <option value="">— Pilih —</option>
                            <option value="Bidang 1" @selected(old('unit_kerja_2') === 'Bidang 1')>Bidang 1</option>
                            <option value="Bidang 2" @selected(old('unit_kerja_2') === 'Bidang 2')>Bidang 2</option>
                        </select>
                        @error('unit_kerja_2')<div class="invalid-feedback small d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Unit Kerja 3</label>
                        <select name="unit_kerja_3" class="form-select form-select-sm">
                            <option value="">— Pilih —</option>
                            <option value="Sub 1" @selected(old('unit_kerja_3') === 'Sub 1')>Sub 1</option>
                            <option value="Sub 2" @selected(old('unit_kerja_3') === 'Sub 2')>Sub 2</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-semibold">Unit Kerja 4</label>
                        <select name="unit_kerja_4" class="form-select form-select-sm">
                            <option value="">— Pilih —</option>
                            <option value="Unit 1" @selected(old('unit_kerja_4') === 'Unit 1')>Unit 1</option>
                            <option value="Unit 2" @selected(old('unit_kerja_4') === 'Unit 2')>Unit 2</option>
                        </select>
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

@endsection
