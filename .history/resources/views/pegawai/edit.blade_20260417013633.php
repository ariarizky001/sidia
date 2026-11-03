@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Edit Pegawai</h3>
                </div>
                <form action="{{ route('pegawai.update', $pegawai->id ?? 1) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- ROW 1 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip">NIP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                           id="nip" name="nip" value="{{ old('nip', $pegawai->nip ?? '') }}" required>
                                    @error('nip')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                           id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap ?? '') }}" required>
                                    @error('nama_lengkap')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ROW 2 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" 
                                           id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $pegawai->tgl_lahir ?? '') }}" required>
                                    @error('tgl_lahir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>

                        <!-- ROW 3 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pensiun">Pensiun</label>
                                    <input type="date" class="form-control @error('pensiun') is-invalid @enderror" 
                                           id="pensiun" name="pensiun" value="{{ old('pensiun', $pegawai->pensiun ?? '') }}">
                                    @error('pensiun')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bup">BUP (Batas Usia Pensiun)</label>
                                    <input type="date" class="form-control @error('bup') is-invalid @enderror" 
                                           id="bup" name="bup" value="{{ old('bup', $pegawai->bup ?? '') }}">
                                    @error('bup')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ROW 4 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="golongan">Golongan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('golongan') is-invalid @enderror" 
                                            id="golongan" name="golongan" required>
                                        <option value="">-- Pilih Golongan --</option>
                                        <option value="I/a" {{ old('golongan', $pegawai->golongan ?? '') === 'I/a' ? 'selected' : '' }}>I/a</option>
                                        <option value="I/b" {{ old('golongan', $pegawai->golongan ?? '') === 'I/b' ? 'selected' : '' }}>I/b</option>
                                        <option value="I/c" {{ old('golongan', $pegawai->golongan ?? '') === 'I/c' ? 'selected' : '' }}>I/c</option>
                                        <option value="I/d" {{ old('golongan', $pegawai->golongan ?? '') === 'I/d' ? 'selected' : '' }}>I/d</option>
                                        <option value="II/a" {{ old('golongan', $pegawai->golongan ?? '') === 'II/a' ? 'selected' : '' }}>II/a</option>
                                        <option value="II/b" {{ old('golongan', $pegawai->golongan ?? '') === 'II/b' ? 'selected' : '' }}>II/b</option>
                                        <option value="II/c" {{ old('golongan', $pegawai->golongan ?? '') === 'II/c' ? 'selected' : '' }}>II/c</option>
                                        <option value="II/d" {{ old('golongan', $pegawai->golongan ?? '') === 'II/d' ? 'selected' : '' }}>II/d</option>
                                        <option value="III/a" {{ old('golongan', $pegawai->golongan ?? '') === 'III/a' ? 'selected' : '' }}>III/a</option>
                                        <option value="III/b" {{ old('golongan', $pegawai->golongan ?? '') === 'III/b' ? 'selected' : '' }}>III/b</option>
                                        <option value="III/c" {{ old('golongan', $pegawai->golongan ?? '') === 'III/c' ? 'selected' : '' }}>III/c</option>
                                        <option value="III/d" {{ old('golongan', $pegawai->golongan ?? '') === 'III/d' ? 'selected' : '' }}>III/d</option>
                                        <option value="IV/a" {{ old('golongan', $pegawai->golongan ?? '') === 'IV/a' ? 'selected' : '' }}>IV/a</option>
                                        <option value="IV/b" {{ old('golongan', $pegawai->golongan ?? '') === 'IV/b' ? 'selected' : '' }}>IV/b</option>
                                        <option value="IV/c" {{ old('golongan', $pegawai->golongan ?? '') === 'IV/c' ? 'selected' : '' }}>IV/c</option>
                                        <option value="IV/d" {{ old('golongan', $pegawai->golongan ?? '') === 'IV/d' ? 'selected' : '' }}>IV/d</option>
                                    </select>
                                    @error('golongan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tmt_golongan">TMT Golongan</label>
                                    <input type="date" class="form-control @error('tmt_golongan') is-invalid @enderror" 
                                           id="tmt_golongan" name="tmt_golongan" value="{{ old('tmt_golongan', $pegawai->tmt_golongan ?? '') }}">
                                    @error('tmt_golongan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ROW 5 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                                           id="jabatan" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan ?? '') }}" required>
                                    @error('jabatan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tmt_jabatan">TMT Jabatan</label>
                                    <input type="date" class="form-control @error('tmt_jabatan') is-invalid @enderror" 
                                           id="tmt_jabatan" name="tmt_jabatan" value="{{ old('tmt_jabatan', $pegawai->tmt_jabatan ?? '') }}">
                                    @error('tmt_jabatan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ROW 6 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pendidikan">Pendidikan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('pendidikan') is-invalid @enderror" 
                                            id="pendidikan" name="pendidikan" required>
                                        <option value="">-- Pilih Pendidikan --</option>
                                        <option value="SD" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'SMA' ? 'selected' : '' }}>SMA/SMK</option>
                                        <option value="D1" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'D1' ? 'selected' : '' }}>D1</option>
                                        <option value="D2" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'D2' ? 'selected' : '' }}>D2</option>
                                        <option value="D3" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                                        <option value="S2" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                                        <option value="S3" {{ old('pendidikan', $pegawai->pendidikan ?? '') === 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                                    </select>
                                    @error('pendidikan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thn_lulus">Tahun Lulus</label>
                                    <input type="number" class="form-control @error('thn_lulus') is-invalid @enderror" 
                                           id="thn_lulus" name="thn_lulus" value="{{ old('thn_lulus', $pegawai->thn_lulus ?? '') }}" min="1950" max="2100">
                                    @error('thn_lulus')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ROW 7 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_asn">Status ASN <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status_asn') is-invalid @enderror" 
                                            id="status_asn" name="status_asn" required>
                                        <option value="">-- Pilih Status ASN --</option>
                                        <option value="PNS" {{ old('status_asn', $pegawai->status_asn ?? '') === 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="PPPK" {{ old('status_asn', $pegawai->status_asn ?? '') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                        <option value="Honorer" {{ old('status_asn', $pegawai->status_asn ?? '') === 'Honorer' ? 'selected' : '' }}>Honorer</option>
                                    </select>
                                    @error('status_asn')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formasi_jabatan">Formasi Jabatan</label>
                                    <input type="text" class="form-control @error('formasi_jabatan') is-invalid @enderror" 
                                           id="formasi_jabatan" name="formasi_jabatan" value="{{ old('formasi_jabatan', $pegawai->formasi_jabatan ?? '') }}">
                                    @error('formasi_jabatan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ROW 8 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_kerja_satu">Unit Kerja 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('unit_kerja_satu') is-invalid @enderror" 
                                           id="unit_kerja_satu" name="unit_kerja_satu" value="{{ old('unit_kerja_satu', $pegawai->unit_kerja_satu ?? '') }}" required>
                                    @error('unit_kerja_satu')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_kerja_2">Unit Kerja 2</label>
                                    <input type="text" class="form-control @error('unit_kerja_2') is-invalid @enderror" 
                                           id="unit_kerja_2" name="unit_kerja_2" value="{{ old('unit_kerja_2', $pegawai->unit_kerja_2 ?? '') }}">
                                    @error('unit_kerja_2')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ROW 9 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_kerja_3">Unit Kerja 3</label>
                                    <input type="text" class="form-control @error('unit_kerja_3') is-invalid @enderror" 
                                           id="unit_kerja_3" name="unit_kerja_3" value="{{ old('unit_kerja_3', $pegawai->unit_kerja_3 ?? '') }}">
                                    @error('unit_kerja_3')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
