@extends('layouts.admin')

@section('title', 'Master Data Unit Kerja')

@section('content')

<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="text-dark fw-bold mb-1">Master Data Unit Kerja</h3>
            <p class="text-muted mb-0">Kelola unit kerja organisasi</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('unit-kerja.importForm') }}" class="btn btn-success me-2">
                <i class="fas fa-file-import"></i> Import Excel
            </a>
            <a href="{{ route('unit-kerja.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Unit Kerja
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            @if($unitKerjas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 45%;">Nama Unit Kerja</th>
                                <th style="width: 20%;">Jenis Unit</th>
                                <th style="width: 20%;">Parent Unit Kerja</th>
                                <th style="width: 5%;">Level</th>
                                <th style="width: 5%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unitKerjas as $index => $unit)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div style="margin-left: {{ ($unit->level - 1) * 20 }}px;">
                                            <strong>{{ $unit->nama }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        @if($unit->jenisUnit)
                                            @if($unit->jenisUnit->is_sekolah)
                                                <span class="badge bg-success">{{ $unit->jenisUnit->nama }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $unit->jenisUnit->nama }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($unit->parent)
                                            <span class="badge bg-info">{{ $unit->parent->nama }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">Level {{ $unit->level }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('unit-kerja.edit', $unit) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('unit-kerja.destroy', $unit) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
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
            @else
                <div class="text-center py-8">
                    <i class="fas fa-building text-secondary" style="font-size: 4rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada data unit kerja</p>
                </div>
            @endif

        </div>
    </div>

</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        font-size: 0.85rem;
        padding: 4px 8px;
    }

    .btn-group {
        gap: 4px;
        display: flex;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .table {
            font-size: 0.9rem;
        }

        th, td {
            padding: 10px 8px !important;
        }

        .btn-group {
            flex-wrap: wrap;
            gap: 3px;
        }
    }
</style>

@endsection
