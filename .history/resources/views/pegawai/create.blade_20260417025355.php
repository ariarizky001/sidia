@extends('layouts.admin')

@section('content')

<div class="accordion-form-container py-4">
    <div class="card accordion-form-card shadow">
        <div class="card-header">
            <h5 class="mb-0 text-white">
                <i class="fas fa-id-card me-2"></i> Data Pegawai / ASN
            </h5>
        </div>

        <form action="{{ route('pegawai.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="accordion" id="formPegawai">

                <!-- A. IDENTITAS PEGAWAI -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#sectionA">
                            <i class="fas fa-user me-2"></i> A. Identitas Pegawai
                        </button>
                    </h2>
                    <div id="sectionA" class="accordion-collapse collapse show" data-bs-parent="#formPegawai">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        NIP <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                           name="nip" value="{{ old('nip') }}" required placeholder="18 digit">
                                    <small class="form-text">18 digit angka</small>
                                    @error('nip')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Status ASN <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('status_asn') is-invalid @enderror" 
                                            name="status_asn" required>
                                        <option value="">— Pilih Status ASN —</option>
                                        <option value="PNS" @selected(old('status_asn') === 'PNS')>PNS</option>
                                        <option value="PPPK" @selected(old('status_asn') === 'PPPK')>PPPK</option>
                                        <option value="Honorer" @selected(old('status_asn') === 'Honorer')>Honorer</option>
                                    </select>
                                    @error('status_asn')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Nama Lengkap <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                           name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap pegawai">
                                    @error('nama_lengkap')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tanggal Lahir <span class="required">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- B. PENSIUN & STATUS AKTIF -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionB">
                            <i class="fas fa-calendar-alt me-2"></i> B. Pensiun & Status Aktif
                        </button>
                    </h2>
                    <div id="sectionB" class="accordion-collapse collapse" data-bs-parent="#formPegawai">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">BUP (Batas Usia Pensiun)</label>
                                    <select class="form-select @error('bup_tahun') is-invalid @enderror" name="bup_tahun">
                                        <option value="">— Pilih —</option>
                                        <option value="58" @selected(old('bup_tahun') === '58')>58 Tahun</option>
                                        <option value="60" @selected(old('bup_tahun') === '60')>60 Tahun</option>
                                        <option value="65" @selected(old('bup_tahun') === '65')>65 Tahun</option>
                                    </select>
                                    @error('bup_tahun')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">
                                        Status Aktif <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('status_aktif') is-invalid @enderror" 
                                            name="status_aktif" required>
                                        <option value="">— Pilih Status —</option>
                                        <option value="aktif" @selected(old('status_aktif') === 'aktif')>Aktif</option>
                                        <option value="nonaktif" @selected(old('status_aktif') === 'nonaktif')>Nonaktif</option>
                                    </select>
                                    @error('status_aktif')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Tanggal Pensiun</label>
                                    <input type="text" class="form-control" readonly placeholder="Auto-calculated">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status Pensiun</label>
                                    <input type="text" class="form-control" readonly placeholder="Auto-calculated">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- C. KEPANGKATAN -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionC">
                            <i class="fas fa-star me-2"></i> C. Kepangkatan
                        </button>
                    </h2>
                    <div id="sectionC" class="accordion-collapse collapse" data-bs-parent="#formPegawai">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Golongan <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('golongan') is-invalid @enderror" 
                                            name="golongan" required>
                                        <option value="">— Pilih Golongan —</option>
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
                                    @error('golongan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        TMT Golongan <span class="required">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('tmt_golongan') is-invalid @enderror" 
                                           name="tmt_golongan" value="{{ old('tmt_golongan') }}" required>
                                    @error('tmt_golongan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- D. JABATAN -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionD">
                            <i class="fas fa-briefcase me-2"></i> D. Jabatan
                        </button>
                    </h2>
                    <div id="sectionD" class="accordion-collapse collapse" data-bs-parent="#formPegawai">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Nama Jabatan <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" 
                                           name="nama_jabatan" value="{{ old('nama_jabatan') }}" required placeholder="Nama jabatan">
                                    @error('nama_jabatan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        TMT Jabatan <span class="required">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('tmt_jabatan') is-invalid @enderror" 
                                           name="tmt_jabatan" value="{{ old('tmt_jabatan') }}" required>
                                    @error('tmt_jabatan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Formasi / Jabatan</label>
                                    <input type="text" class="form-control" 
                                           name="formasi_jabatan" value="{{ old('formasi_jabatan') }}" placeholder="Formasi jabatan (opsional)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- E. PENDIDIKAN -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionE">
                            <i class="fas fa-book me-2"></i> E. Pendidikan
                        </button>
                    </h2>
                    <div id="sectionE" class="accordion-collapse collapse" data-bs-parent="#formPegawai">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Jenjang Pendidikan <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('jenjang_pendidikan') is-invalid @enderror" 
                                            name="jenjang_pendidikan" required>
                                        <option value="">— Pilih Jenjang —</option>
                                        <option value="SD" @selected(old('jenjang_pendidikan') === 'SD')>SD</option>
                                        <option value="SMP" @selected(old('jenjang_pendidikan') === 'SMP')>SMP</option>
                                        <option value="SMA" @selected(old('jenjang_pendidikan') === 'SMA')>SMA / SMK</option>
                                        <option value="D3" @selected(old('jenjang_pendidikan') === 'D3')>D3 (Diploma)</option>
                                        <option value="S1" @selected(old('jenjang_pendidikan') === 'S1')>S1 (Sarjana)</option>
                                        <option value="S2" @selected(old('jenjang_pendidikan') === 'S2')>S2 (Magister)</option>
                                        <option value="S3" @selected(old('jenjang_pendidikan') === 'S3')>S3 (Doktor)</option>
                                    </select>
                                    @error('jenjang_pendidikan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Lulus</label>
                                    <input type="number" class="form-control" 
                                           name="tahun_lulus" value="{{ old('tahun_lulus') }}" min="1980" max="2100" placeholder="Tahun lulus">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- F. UNIT KERJA -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionF">
                            <i class="fas fa-building me-2"></i> F. Unit Kerja
                        </button>
                    </h2>
                    <div id="sectionF" class="accordion-collapse collapse" data-bs-parent="#formPegawai">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Unit Kerja 1 <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('unit_kerja_satu') is-invalid @enderror" 
                                            name="unit_kerja_satu" required>
                                        <option value="">— Pilih Unit Kerja 1 —</option>
                                        <option value="Dinas Pendidikan" @selected(old('unit_kerja_satu') === 'Dinas Pendidikan')>Dinas Pendidikan</option>
                                        <option value="Dinas Kesehatan" @selected(old('unit_kerja_satu') === 'Dinas Kesehatan')>Dinas Kesehatan</option>
                                    </select>
                                    @error('unit_kerja_satu')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Unit Kerja 2 <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('unit_kerja_2') is-invalid @enderror" 
                                            name="unit_kerja_2" required>
                                        <option value="">— Pilih Unit Kerja 2 —</option>
                                        <option value="Bidang 1" @selected(old('unit_kerja_2') === 'Bidang 1')>Bidang 1</option>
                                        <option value="Bidang 2" @selected(old('unit_kerja_2') === 'Bidang 2')>Bidang 2</option>
                                    </select>
                                    @error('unit_kerja_2')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit Kerja 3</label>
                                    <select class="form-select" name="unit_kerja_3">
                                        <option value="">— Pilih Unit Kerja 3 —</option>
                                        <option value="Sub 1" @selected(old('unit_kerja_3') === 'Sub 1')>Sub 1</option>
                                        <option value="Sub 2" @selected(old('unit_kerja_3') === 'Sub 2')>Sub 2</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit Kerja 4</label>
                                    <select class="form-select" name="unit_kerja_4">
                                        <option value="">— Pilih Unit Kerja 4 —</option>
                                        <option value="Unit 1" @selected(old('unit_kerja_4') === 'Unit 1')>Unit 1</option>
                                        <option value="Unit 2" @selected(old('unit_kerja_4') === 'Unit 2')>Unit 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer text-end">
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary-outline me-2">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="reset" class="btn btn-secondary me-2">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary-gradient">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
                                <div class="col-md-6">
                                    <label>TMT</label>
                                    <input type="date" name="tmt_golongan" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- D -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#d">
                            D. Jabatan
                        </button>
                    </h2>
                    <div id="d" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <input type="text" name="nama_jabatan" class="form-control mb-2" placeholder="Nama Jabatan">
                            <input type="date" name="tmt_jabatan" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- E -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#e">
                            E. Pendidikan
                        </button>
                    </h2>
                    <div id="e" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <select name="jenjang_pendidikan" class="form-select mb-2"></select>
                            <input type="text" name="tahun_lulus" class="form-control">
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-success">Simpan</button>
        </div>

    </form>

</div>


</div>

@endsection
