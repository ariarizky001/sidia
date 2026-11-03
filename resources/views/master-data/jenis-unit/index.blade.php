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
                    <h4 class="fw-bold text-dark mb-0">Master Data Jenis Unit</h4>
                    <p class="text-muted small mb-0">Kelola kategori unit kerja (Dinas, Bidang, Koordinator Wilayah, SD, SMP, TK, dll)</p>
                </div>
                <a href="{{ route('jenis-unit.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Jenis Unit
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

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Table -->
            @if ($jenisUnits->count() > 0)
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" width="50">No</th>
                                    <th>Nama</th>
                                    <th width="110">Kode</th>
                                    <th width="90">Level</th>
                                    <th width="100">Tipe</th>
                                    <th width="90">Jumlah</th>
                                    <th class="text-end pe-4" width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenisUnits as $key => $item)
                                    <tr>
                                        <td class="ps-4">{{ $jenisUnits->firstItem() + $key }}</td>
                                        <td>
                                            <a href="{{ route('jenis-unit.show', $item->id) }}" class="fw-bold text-primary text-decoration-none">
                                                {{ $item->nama }}
                                            </a>
                                            @if ($item->deskripsi)
                                                <div class="small text-muted">{{ $item->deskripsi }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $item->kode }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">L{{ $item->level }}</span>
                                        </td>
                                        <td>
                                            @if ($item->is_sekolah)
                                                <span class="badge bg-success">Sekolah</span>
                                            @else
                                                <span class="badge bg-secondary">Non-Sekolah</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $item->unit_kerjas_count }} unit</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('jenis-unit.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('jenis-unit.destroy', $item->id) }}" style="display:inline;">
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
                    {{ $jenisUnits->links() }}
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada data jenis unit</p>
                        <a href="{{ route('jenis-unit.create') }}" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-plus me-1"></i> Tambah Jenis Unit Pertama
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
