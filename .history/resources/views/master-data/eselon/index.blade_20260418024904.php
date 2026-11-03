@extends('layouts.admin')

@section('title', 'Master Data Eselon')

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
                    <h4 class="fw-bold text-dark mb-0">Master Data Eselon</h4>
                    <p class="text-muted small mb-0">Kelola daftar eselon jabatan</p>
                </div>
                <a href="{{ route('eselon.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Eselon
                </a>
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

            <!-- Table -->
            @if ($eselons->count() > 0)
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" width="50">No</th>
                                    <th width="100">Kode</th>
                                    <th>Nama Eselon</th>
                                    <th>Deskripsi</th>
                                    <th width="100">Status</th>
                                    <th class="text-end pe-4" width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eselons as $key => $item)
                                    <tr>
                                        <td class="ps-4">{{ $eselons->firstItem() + $key }}</td>
                                        <td><span class="badge bg-info">{{ $item->kode }}</span></td>
                                        <td class="fw-bold text-primary">{{ $item->nama_eselon }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $item->deskripsi ? substr($item->deskripsi, 0, 50) . (strlen($item->deskripsi) > 50 ? '...' : '') : '-' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if ($item->status === 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('eselon.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('eselon.destroy', $item->id) }}" style="display:inline;">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $eselons->links() }}
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada data eselon</p>
                        <a href="{{ route('eselon.create') }}" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-plus me-1"></i> Tambah Eselon Pertama
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
