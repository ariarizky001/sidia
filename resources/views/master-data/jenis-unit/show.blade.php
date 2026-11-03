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
                    <h4 class="fw-bold text-dark mb-0">{{ $jenisUnit->nama }}</h4>
                    <p class="text-muted small mb-0">Detail jenis unit dan daftar unit kerja di dalamnya</p>
                </div>
                <a href="{{ route('jenis-unit.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Informasi Jenis Unit</h5>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Kode</td>
                            <td><span class="badge bg-info">{{ $jenisUnit->kode }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama</td>
                            <td class="fw-semibold">{{ $jenisUnit->nama }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Deskripsi</td>
                            <td>{{ $jenisUnit->deskripsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Level</td>
                            <td><span class="badge bg-secondary">Level {{ $jenisUnit->level }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tipe</td>
                            <td>
                                @if ($jenisUnit->is_sekolah)
                                    <span class="badge bg-success">Sekolah</span>
                                @else
                                    <span class="badge bg-secondary">Non-Sekolah</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jumlah Unit</td>
                            <td><span class="fw-bold">{{ $unitKerjas->total() }} unit</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0"><i class="fas fa-building me-2"></i>Daftar Unit Kerja</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="50">No</th>
                                <th>Nama Unit Kerja</th>
                                <th>Induk</th>
                                <th>Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($unitKerjas as $key => $item)
                                <tr>
                                    <td class="ps-4">{{ $unitKerjas->firstItem() + $key }}</td>
                                    <td class="fw-semibold">{{ $item->nama }}</td>
                                    <td class="small text-muted">{{ $item->parent->nama ?? '-' }}</td>
                                    <td><span class="badge bg-secondary">L{{ $item->level }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Belum ada unit kerja dengan jenis ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($unitKerjas->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $unitKerjas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
