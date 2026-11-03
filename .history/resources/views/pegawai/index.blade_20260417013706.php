@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Daftar Pegawai</h3>
                    <div class="card-tools pull-right">
                        <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Pegawai
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($pegawai) === 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada data pegawai.
                            <a href="{{ route('pegawai.create') }}">Tambahkan pegawai baru</a>
                        </div>
                    @else
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Golongan</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pegawai as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nip ?? '-' }}</td>
                                        <td>{{ $item->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $item->golongan ?? '-' }}</td>
                                        <td>{{ $item->jabatan ?? '-' }}</td>
                                        <td>{{ $item->unit_kerja_satu ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('pegawai.show', $item->id) }}" class="btn btn-xs btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-xs btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
