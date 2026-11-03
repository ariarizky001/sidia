@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Data Pegawai / ASN</h4>
                    <p class="text-muted small mb-0">Kelola semua data pegawai di sistem</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('pegawai.importForm') }}" class="btn btn-sm btn-info">
                        <i class="fas fa-file-excel me-1"></i> Import Excel
                    </a>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Pegawai
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-12">

            <!-- Alert Messages -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Table -->
            @if ($pegawai->count() > 0)
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">NIP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Status ASN</th>
                                    <th>Golongan</th>
                                    <th>Jabatan</th>
                                    <th>Status Aktif</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pegawai as $item)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">{{ $item->nip }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->nama_lengkap }}</div>
                                            <small class="text-muted">{{ $item->tgl_lahir?->format('d M Y') ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $item->status_asn }}</span>
                                        </td>
                                        <td>{{ $item->golongan ?? '-' }}</td>
                                        <td>{{ $item->jabatan ?? '-' }}</td>
                                        <td>
                                            @if ($item->status_aktif === 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('pegawai.show', $item->id) }}" class="btn btn-outline-primary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('pegawai.destroy', $item->id) }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus"
                                                            onclick="return confirm('Yakin akan menghapus data ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada data pegawai</p>
                        <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-plus me-1"></i> Tambah Pegawai Pertama
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

</div>

@endsection
