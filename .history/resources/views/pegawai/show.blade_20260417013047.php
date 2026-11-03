@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8">
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
                    <table class="table table-striped">
                        <tr>
                            <td width="200"><strong>Nama</strong></td>
                            <td>{{ $pegawai->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIP</strong></td>
                            <td>{{ $pegawai->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $pegawai->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Telepon</strong></td>
                            <td>{{ $pegawai->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Departemen</strong></td>
                            <td>{{ $pegawai->department ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Posisi/Jabatan</strong></td>
                            <td>{{ $pegawai->position ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Bergabung</strong></td>
                            <td>{{ $pegawai->start_date ?? '-' }}</td>
                        </tr>
                    </table>
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
