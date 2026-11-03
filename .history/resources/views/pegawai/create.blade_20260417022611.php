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

                    <!-- A. IDENTITAS -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>A. IDENTITAS PEGAWAI</strong>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">NIP *</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required>
                                <small>18 digit</small>
                                @error('nip')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap *</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status ASN *</label>
                                    <select class="form-select" name="status_asn" required>
                                        <option value="">— Pilih —</option>
                                        <option value="PNS">PNS</option>
                                        <option value="PPPK">PPPK</option>
                                        <option value="Honorer">Honorer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Tanggal Lahir *</label>
                                <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            </div>

                        </div>
                    </div>

                    <!-- B. PENSIUN -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>B. PENSIUN</strong>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <label>BUP</label>
                                    <select class="form-select" name="bup_tahun">
                                        <option value="">— Pilih —</option>
                                        <option value="58">58</option>
                                        <option value="60">60</option>
                                        <option value="65">65</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Tanggal Pensiun</label>
                                    <input type="text" class="form-control bg-light" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Status</label>
                                    <input type="text" class="form-control bg-light" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Status Aktif *</label>
                                    <select class="form-select @error('status_aktif') is-invalid @enderror" name="status_aktif" required>
                                        <option value="">— Pilih —</option>
                                        <option value="aktif" @selected(old('status_aktif') === 'aktif')>Aktif</option>
                                        <option value="nonaktif" @selected(old('status_aktif') === 'nonaktif')>Nonaktif</option>
                                    </select>
                                    @error('status_aktif')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- C. GOLONGAN -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>C. KEPANGKATAN</strong>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Golongan *</label>
                                    <select class="form-select" name="golongan" required>
                                        <option value="">— Pilih —</option>
                                        <option>I/a</option><option>I/b</option>
                                        <option>II/a</option><option>II/b</option>
                                        <option>III/a</option><option>III/b</option>
                                        <option>IV/a</option><option>IV/b</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>TMT *</label>
                                    <input type="date" class="form-control" name="tmt_golongan" required>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- D. JABATAN -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>D. JABATAN</strong>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nama Jabatan *</label>
                                    <input type="text" class="form-control" name="nama_jabatan" required>
                                </div>
                                <div class="col-md-6">
                                    <label>TMT Jabatan *</label>
                                    <input type="date" class="form-control" name="tmt_jabatan" required>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label>Formasi</label>
                                <input type="text" class="form-control" name="formasi_jabatan">
                            </div>

                        </div>
                    </div>

                    <!-- E. PENDIDIKAN -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>E. PENDIDIKAN</strong>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Jenjang *</label>
                                    <select class="form-select" name="jenjang_pendidikan" required>
                                        <option value="">— Pilih —</option>
                                        <option>SD</option>
                                        <option>SMP</option>
                                        <option>SMA</option>
                                        <option>D3</option>
                                        <option>S1</option>
                                        <option>S2</option>
                                        <option>S3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Tahun Lulus</label>
                                    <input type="text" class="form-control" name="tahun_lulus">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- F. UNIT KERJA -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>F. UNIT KERJA</strong>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label>Unit 1 *</label>
                                <select class="form-select" name="unit_kerja_1" required>
                                    <option value="">— Pilih —</option>
                                    <option>Dinas Pendidikan</option>
                                    <option>Dinas Kesehatan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Unit 2 *</label>
                                <select class="form-select" name="unit_kerja_2" required>
                                    <option value="">— Pilih —</option>
                                    <option>Bidang 1</option>
                                    <option>Bidang 2</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Unit 3 *</label>
                                <select class="form-select" name="unit_kerja_3" required>
                                    <option value="">— Pilih —</option>
                                    <option>Sub 1</option>
                                    <option>Sub 2</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Unit 4 *</label>
                                <select class="form-select" name="unit_kerja_4" required>
                                    <option value="">— Pilih —</option>
                                    <option>Unit 1</option>
                                    <option>Unit 2</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                    <button type="reset" class="btn btn-warning btn-sm">Reset</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>
```

</div>
@endsection
