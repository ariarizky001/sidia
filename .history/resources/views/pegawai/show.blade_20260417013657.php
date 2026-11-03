@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Detail Pegawai</h3>
                    <div class="card-tools pull-right">
                        <a href="{{ route('pegawai.edit', $pegawai->id ?? 1) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <td width="40%"><strong>NIP</strong></td>
                                    <td>{{ $pegawai->nip ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Lengkap</strong></td>
                                    <td>{{ $pegawai->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Lahir</strong></td>
                                    <td>{{ $pegawai->tgl_lahir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pensiun</strong></td>
                                    <td>{{ $pegawai->pensiun ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>BUP</strong></td>
                                    <td>{{ $pegawai->bup ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Golongan</strong></td>
                                    <td>{{ $pegawai->golongan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>TMT Golongan</strong></td>
                                    <td>{{ $pegawai->tmt_golongan ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <td width="40%"><strong>Jabatan</strong></td>
                                    <td>{{ $pegawai->jabatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>TMT Jabatan</strong></td>
                                    <td>{{ $pegawai->tmt_jabatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pendidikan</strong></td>
                                    <td>{{ $pegawai->pendidikan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Lulus</strong></td>
                                    <td>{{ $pegawai->thn_lulus ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status ASN</strong></td>
                                    <td>{{ $pegawai->status_asn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Formasi Jabatan</strong></td>
                                    <td>{{ $pegawai->formasi_jabatan ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h5>Unit Kerja</h5>
                            <table class="table table-striped">
                                <tr>
                                    <td width="20%"><strong>Unit Kerja 1</strong></td>
                                    <td>{{ $pegawai->unit_kerja_satu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Unit Kerja 2</strong></td>
                                    <td>{{ $pegawai->unit_kerja_2 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Unit Kerja 3</strong></td>
                                    <td>{{ $pegawai->unit_kerja_3 ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('pegawai.destroy', $pegawai->id ?? 1) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data pegawai ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
