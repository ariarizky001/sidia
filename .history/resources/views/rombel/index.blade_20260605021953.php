@extends('layouts.admin')

@section('content')

<style>
    body {
        background-color: #f4f6f9;
    }

    .page-header {
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 100;
        padding: 18px 0;
        margin-bottom: 24px;
        border-bottom: 1px solid #dee2e6;
    }

    .page-title {
        font-weight: 700;
        color: #2c3e50;
    }

    .card-custom {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        overflow: hidden;
        background: #fff;
    }

    .table-custom {
        margin-bottom: 0;
        border: 1px solid #dee2e6;
    }

    .table-custom thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid #dee2e6 !important;
        vertical-align: middle;
        padding: 14px 12px;
    }

    .table-custom tbody td {
        border: 1px solid #dee2e6 !important;
        vertical-align: middle;
        padding: 14px 12px;
        font-size: 14px;
    }

    .table-custom tbody tr:hover {
        background-color: #f9fbfd;
    }

    .badge-rombel {
        font-size: 13px;
        padding: 8px 12px;
        border-radius: 6px;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }

    .stats-card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        background: white;
        transition: .2s;
    }

    .stats-card:hover {
        transform: translateY(-2px);
    }

    .stats-number {
        font-size: 24px;
        font-weight: 700;
    }

    .filter-card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        background: #fff;
    }

    .empty-state i {
        font-size: 60px;
        color: #ced4da;
    }

    .inline-form-input {
        width: 60px !important;
        text-align: center;
        font-size: 13px;
        height: 32px;
        padding: 4px 8px;
    }

    .inline-form-btn {
        padding: 4px 8px !important;
        font-size: 12px !important;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .inline-form-input:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

<div class="container-fluid">

    <!-- Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="page-title mb-1">Data Master Rombel</h3>
                <small class="text-muted">
                    Kelola jumlah rombel berdasarkan kecamatan dan sekolah
                </small>
            </div>

            <a href="{{ route('rombel.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>
                Tambah Data
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter -->
    <div class="card filter-card mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('rombel.index') }}">

                <div class="d-flex flex-wrap align-items-end gap-2">

                    <!-- Dropdown -->
                    <div style="min-width: 320px; flex: 1;">

                        <label class="form-label fw-semibold">
                            Koordinator Wilayah / Kecamatan
                        </label>

                        <select name="kecamatan"
                                class="form-select"
                                onchange="this.form.submit()">

                            <option value="">-- Semua Kecamatan --</option>

                            @foreach($unitKerjaLevel2 as $uk)

                                <option value="{{ $uk->id }}"
                                    {{ $filterKecamatan == $uk->id ? 'selected' : '' }}>

                                    {{ $uk->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Tombol Reset -->
                    @if($filterKecamatan)

                        <div>

                            <button type="submit"
                                    formaction="{{ route('rombel.index') }}"
                                    class="btn btn-secondary">

                                <i class="fas fa-undo-alt me-1"></i>
                                Reset

                            </button>

                        </div>

                    @endif

                </div>

            </form>

        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <small class="text-muted">Total Rombel</small>
                    <div class="stats-number text-primary">
                        {{ $totalRombel }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <small class="text-muted">Total Kecamatan</small>
                    <div class="stats-number text-info">
                        {{ $statistik['total_kecamatan'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <small class="text-muted">Total Sekolah</small>
                    <div class="stats-number text-success">
                        {{ $statistik['total_sekolah'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <small class="text-muted">Rata-rata</small>
                    <div class="stats-number text-warning">
                        {{ $statistik['total_sekolah'] > 0 ? round($totalRombel / $statistik['total_sekolah'], 1) : 0 }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Table -->
    @if($sekolahList->count() > 0)

        <div class="card card-custom">

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-custom">

                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        @if(!$filterKecamatan)
                            <th>Kecamatan</th>
                        @endif
                        <th>Sekolah</th>
                        <th width="15%" class="text-center">Jumlah Rombel</th>
                        <th width="18%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($sekolahList as $sekolah)

                        @php
                            $rombel = $sekolah->rombels->first();
                            $jumlahRombel = $rombel ? $rombel->jumlah_rombel : 0;
                            $rombelId = $rombel ? $rombel->id : null;
                        @endphp

                        <tr>

                            <td class="text-center fw-bold">
                                {{ $sekolahList->firstItem() + $loop->index }}
                            </td>

                            @if(!$filterKecamatan)
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 text-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div>
                                            {{ $sekolah->parent?->nama ?? '-' }}
                                        </div>
                                    </div>
                                </td>
                            @endif

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2 text-primary">
                                        <i class="fas fa-school"></i>
                                        </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $sekolah->nama }}
                                        </div>

                                        @if($rombel && $rombel->keterangan)
                                            <small class="text-muted">
                                                {{ Str::limit($rombel->keterangan, 40) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                @if($rombelId)
                                    <!-- Edit Mode - Jika sudah ada data -->
                                    <form action="{{ route('rombel.update-inline', $rombelId) }}" 
                                          method="POST" 
                                          class="d-flex align-items-center justify-content-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @if($filterKecamatan)
                                            <input type="hidden" name="kecamatan" value="{{ $filterKecamatan }}">
                                        @endif
                                        
                                        <input type="number" 
                                               name="jumlah_rombel" 
                                               value="{{ $jumlahRombel }}" 
                                               min="0"
                                               class="form-control form-control-sm inline-form-input"
                                               autocomplete="off">
                                        
                                        <button type="submit" 
                                                class="btn btn-sm btn-success inline-form-btn"
                                                title="Simpan">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <!-- Add Mode - Jika belum ada data -->
                                    <form action="{{ route('rombel.store-inline') }}" 
                                          method="POST"
                                          class="d-flex align-items-center justify-content-center gap-2">
                                        @csrf
                                        
                                        <input type="hidden" name="unit_kerja_id" value="{{ $sekolah->id }}">
                                        <input type="hidden" name="unit_kerja_parent_id" value="{{ $sekolah->parent_id }}">
                                        
                                        @if($filterKecamatan)
                                            <input type="hidden" name="kecamatan" value="{{ $filterKecamatan }}">
                                        @endif
                                        
                                        <input type="number" 
                                               name="jumlah_rombel" 
                                               value="0" 
                                               min="0"
                                               placeholder="Qty"
                                               class="form-control form-control-sm inline-form-input"
                                               autocomplete="off"
                                               required>
                                        
                                        <button type="submit" 
                                                class="btn btn-sm btn-primary inline-form-btn"
                                                title="Simpan">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-1">

                                    @if ($rombelId)
                                        <a href="{{ route('rombel.show', $rombelId) }}"
                                        class="btn btn-sm btn-outline-primary btn-action"
                                        title="Detail">

                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('rombel.edit', $rombelId) }}"
                                        class="btn btn-sm btn-outline-warning btn-action"
                                        title="Edit">

                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('rombel.destroy', $rombelId) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger btn-action"
                                                    title="Hapus">

                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <div class="text-muted small">
                    Menampilkan <strong>{{ $sekolahList->firstItem() }}</strong> hingga <strong>{{ $sekolahList->lastItem() }}</strong> dari <strong>{{ $sekolahList->total() }}</strong> sekolah
                </div>
                <nav>
                    {{ $sekolahList->links('pagination::bootstrap-4') }}
            </div>

        </div>

    @else

        <div class="card card-custom">
            <div class="card-body text-center py-5 empty-state">

                <i class="fas fa-inbox"></i>

                <h5 class="mt-3">Belum Ada Data Rombel</h5>

                <p class="text-muted">
                    Silakan tambahkan data rombel terlebih dahulu
                </p>

                <a href="{{ route('rombel.create') }}"
                   class="btn btn-primary">

                    <i class="fas fa-plus-circle me-1"></i>
                    Tambah Data
                </a>

            </div>
        </div>

    @endif

</div>

@endsection
