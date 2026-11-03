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

    .badge-status {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 4px;
        font-weight: 600;
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

    .formasi-mini {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-right: 4px;
        margin-bottom: 4px;
    }

    .formasi-mini.lengkap {
        background-color: #d6efd8;
        color: #1a6b22;
    }

    .formasi-mini.parsial {
        background-color: #faeeda;
        color: #854f0b;
    }

    .formasi-mini.kosong {
        background-color: #fce4d6;
        color: #9c2b1b;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
</style>

<div class="container-fluid">

    <!-- Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="page-title mb-1">Kebutuhan Guru per Sekolah</h3>
                <small class="text-muted">
                    Analisa pemenuhan guru berdasarkan formasi dan jumlah rombel
                </small>
            </div>
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
            <form method="GET" action="{{ route('kebutuhan-guru.index') }}">
                <div class="d-flex flex-wrap align-items-end gap-2">

                    <!-- Filter Kecamatan -->
                    <div style="min-width: 280px; flex: 1;">
                        <label class="form-label fw-semibold">Koordinator Wilayah / Kecamatan</label>
                        <select name="kecamatan" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Kecamatan --</option>
                            @foreach($unitKerjaLevel2 as $uk)
                                <option value="{{ $uk->id }}" {{ $filterKecamatan == $uk->id ? 'selected' : '' }}>
                                    {{ $uk->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div style="min-width: 200px;">
                        <label class="form-label fw-semibold">Status Pemenuhan</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            <option value="LENGKAP" {{ $filterStatus == 'LENGKAP' ? 'selected' : '' }}>
                                <i class="fas fa-check-circle"></i> Lengkap
                            </option>
                            <option value="PARSIAL" {{ $filterStatus == 'PARSIAL' ? 'selected' : '' }}>
                                <i class="fas fa-exclamation-circle"></i> Parsial
                            </option>
                            <option value="KOSONG" {{ $filterStatus == 'KOSONG' ? 'selected' : '' }}>
                                <i class="fas fa-times-circle"></i> Kosong
                            </option>
                        </select>
                    </div>

                    <!-- Tombol Reset -->
                    @if($filterKecamatan || $filterStatus)
                        <div>
                            <button type="submit" formaction="{{ route('kebutuhan-guru.index') }}" class="btn btn-secondary">
                                <i class="fas fa-undo-alt me-1"></i> Reset
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
                    <small class="text-muted">Total Sekolah</small>
                    <div class="stats-number text-primary">
                        {{ $statistik['total_sekolah'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <small class="text-muted">Sekolah Lengkap</small>
                    <div class="stats-number text-success">
                        {{ $statistik['sekolah_lengkap'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <small class="text-muted">Sekolah Parsial</small>
                    <div class="stats-number text-warning">
                        {{ $statistik['sekolah_parsial'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <small class="text-muted">Sekolah Kosong</small>
                    <div class="stats-number text-danger">
                        {{ $statistik['sekolah_kosong'] }}
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
                        <th width="12%" class="text-center">Rombel</th>
                        <th class="text-center">Guru Kelas</th>
                        <th class="text-center">Guru Penjas</th>
                        <th class="text-center">Guru Agama</th>
                        <th width="12%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($sekolahList as $sekolah)

                        @php
                            $mapping = $mappingData[$sekolah->id] ?? null;
                            if (!$mapping) continue; // Skip jika tidak ada mapping
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
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-info">
                                    {{ $mapping['jumlah_rombel'] ?? 0 }} Rombel
                                </span>
                            </td>

                            <td class="text-center">
                                <div>
                                    <small class="d-block">Ada: {{ $mapping['guru_kelas']['ada'] ?? 0 }}</small>
                                    <small class="d-block">Butuh: {{ $mapping['guru_kelas']['kebutuhan'] ?? 0 }}</small>
                                    <span class="formasi-mini {{ strtolower($mapping['guru_kelas']['status'] ?? 'kosong') }}">
                                        {{ $mapping['guru_kelas']['status'] ?? 'KOSONG' }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-center">
                                <div>
                                    <small class="d-block">Ada: {{ $mapping['guru_penjas']['ada'] ?? 0 }}</small>
                                    <small class="d-block">Butuh: {{ $mapping['guru_penjas']['kebutuhan'] ?? 0 }}</small>
                                    <span class="formasi-mini {{ strtolower($mapping['guru_penjas']['status'] ?? 'kosong') }}">
                                        {{ $mapping['guru_penjas']['status'] ?? 'KOSONG' }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-center">
                                <div>
                                    <small class="d-block">Ada: {{ $mapping['guru_agama']['ada'] ?? 0 }}</small>
                                    <small class="d-block">Butuh: {{ $mapping['guru_agama']['kebutuhan'] ?? 0 }}</small>
                                    <span class="formasi-mini {{ strtolower($mapping['guru_agama']['status'] ?? 'kosong') }}">
                                        {{ $mapping['guru_agama']['status'] ?? 'KOSONG' }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-center">
                                @php
                                    $statusBadge = match($mapping['status'] ?? 'kosong') {
                                        'LENGKAP' => ['bg-success', 'Lengkap'],
                                        'PARSIAL' => ['bg-warning', 'Parsial'],
                                        'KOSONG' => ['bg-danger', 'Kosong'],
                                        default => ['bg-secondary', 'Unknown']
                                    };
                                @endphp
                                <span class="badge {{ $statusBadge[0] }} badge-status">
                                    {{ $statusBadge[1] }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('kebutuhan-guru.show', $sekolah->id) }}"
                                   class="btn btn-sm btn-outline-primary btn-action"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
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
                </nav>
            </div>

        </div>

    @else

        <div class="card card-custom">
            <div class="card-body text-center py-5 empty-state">

                <i class="fas fa-inbox"></i>

                <h5 class="mt-3">Belum Ada Data</h5>

                <p class="text-muted">
                    Silakan periksa filter atau tambahkan data terlebih dahulu
                </p>

            </div>
        </div>

    @endif

</div>

@endsection
