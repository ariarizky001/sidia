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

    .formasi-block {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background: #fff;
    }

    .formasi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .formasi-title {
        font-size: 16px;
        font-weight: 700;
        color: #2c3e50;
    }

    .formasi-badge {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 4px;
        font-weight: 600;
    }

    .formasi-badge.lengkap {
        background-color: #d6efd8;
        color: #1a6b22;
    }

    .formasi-badge.parsial {
        background-color: #faeeda;
        color: #854f0b;
    }

    .formasi-badge.kosong {
        background-color: #fce4d6;
        color: #9c2b1b;
    }

    .formasi-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 15px;
    }

    .stat-item {
        text-align: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
    }

    .stat-item-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .stat-item-value {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
    }

    .guru-list {
        margin-top: 15px;
    }

    .guru-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        margin-bottom: 8px;
        background: #fff;
    }

    .guru-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        margin-right: 12px;
        font-size: 14px;
    }

    .guru-info {
        flex: 1;
    }

    .guru-name {
        font-weight: 600;
        font-size: 14px;
        color: #2c3e50;
    }

    .guru-nip {
        font-size: 12px;
        color: #6c757d;
    }

    .slot-kosong {
        display: flex;
        align-items: center;
        padding: 12px;
        border: 2px dashed #ccc;
        border-radius: 6px;
        margin-bottom: 8px;
        background: #f9f9f9;
        color: #999;
    }

    .slot-kosong i {
        margin-right: 10px;
        font-size: 16px;
    }

    .school-info {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        border-radius: 8px;
    }

    .info-label {
        font-size: 12px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 700;
    }

    .btn-back {
        margin-bottom: 15px;
    }

    .empty-formasi {
        text-align: center;
        color: #999;
        padding: 20px;
    }
</style>

<div class="container-fluid">

    <!-- Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="page-title mb-1">Detail Kebutuhan Guru</h3>
                <small class="text-muted">
                    Analisa pemenuhan guru per formasi di {{ $sekolah->nama }}
                </small>
            </div>
            <a href="{{ route('kebutuhan-guru.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
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

    <!-- Informasi Sekolah -->
    <div class="school-info">

        <div class="info-card">
            <div class="info-label">Kecamatan</div>
            <div class="info-value">{{ $sekolah->parent?->nama ?? '-' }}</div>
        </div>

        <div class="info-card">
            <div class="info-label">Jumlah Rombel</div>
            <div class="info-value">{{ $mapping['jumlah_rombel'] ?? 0 }}</div>
        </div>

        <div class="info-card">
            <div class="info-label">Status Pemenuhan</div>
            <div class="info-value">
                @php
                    $statusLabel = match($mapping['status'] ?? 'kosong') {
                        'LENGKAP' => 'Lengkap ✓',
                        'PARSIAL' => 'Parsial ⚠',
                        'KOSONG' => 'Kosong ✗',
                        default => 'Unknown'
                    };
                @endphp
                {{ $statusLabel }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">Total Guru Ada</div>
            <div class="info-value">
                {{ ($mapping['guru_kelas']['ada'] ?? 0) + ($mapping['guru_penjas']['ada'] ?? 0) + ($mapping['guru_agama']['ada'] ?? 0) }}
            </div>
        </div>

    </div>

    <!-- Guru Kelas -->
    <div class="formasi-block">

        <div class="formasi-header">
            <div>
                <div class="formasi-title">
                    <i class="fas fa-chalkboard-user me-2 text-primary"></i>
                    Guru Kelas SD
                </div>
            </div>
            <span class="formasi-badge {{ strtolower($mapping['guru_kelas']['status'] ?? 'kosong') }}">
                {{ $mapping['guru_kelas']['status'] ?? 'KOSONG' }}
            </span>
        </div>

        <div class="formasi-stats">

            <div class="stat-item">
                <div class="stat-item-label">Kebutuhan</div>
                <div class="stat-item-value text-info">
                    {{ $mapping['guru_kelas']['kebutuhan'] ?? 0 }}
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-item-label">Yang Ada</div>
                <div class="stat-item-value text-success">
                    {{ $mapping['guru_kelas']['ada'] ?? 0 }}
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-item-label">Kekurangan</div>
                <div class="stat-item-value text-danger">
                    {{ $mapping['guru_kelas']['kurang'] ?? 0 }}
                </div>
            </div>

        </div>

        <div class="guru-list">

            @if($guruKelas->count() > 0)

                @foreach($guruKelas as $guru)

                    <div class="guru-item">
                        <div class="guru-avatar">
                            {{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}
                        </div>
                        <div class="guru-info">
                            <div class="guru-name">{{ $guru->nama_lengkap }}</div>
                            <div class="guru-nip">{{ $guru->nip }}</div>
                        </div>
                    </div>

                @endforeach

            @endif

            @php
                $slotKosongKelas = ($mapping['guru_kelas']['kebutuhan'] ?? 0) - ($mapping['guru_kelas']['ada'] ?? 0);
            @endphp

            @for($i = 0; $i < $slotKosongKelas; $i++)

                <div class="slot-kosong">
                    <i class="fas fa-user-slash"></i>
                    <span>Slot {{ $mapping['guru_kelas']['ada'] + $i + 1 }} - Kosong</span>
                </div>

            @endfor

        </div>

    </div>

    <!-- Guru Penjas -->
    <div class="formasi-block">

        <div class="formasi-header">
            <div>
                <div class="formasi-title">
                    <i class="fas fa-person-hiking me-2 text-success"></i>
                    Guru Pendidikan Jasmani SD
                </div>
            </div>
            <span class="formasi-badge {{ strtolower($mapping['guru_penjas']['status'] ?? 'kosong') }}">
                {{ $mapping['guru_penjas']['status'] ?? 'KOSONG' }}
            </span>
        </div>

        <div class="formasi-stats">

            <div class="stat-item">
                <div class="stat-item-label">Kebutuhan</div>
                <div class="stat-item-value text-info">
                    {{ $mapping['guru_penjas']['kebutuhan'] ?? 0 }}
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-item-label">Yang Ada</div>
                <div class="stat-item-value text-success">
                    {{ $mapping['guru_penjas']['ada'] ?? 0 }}
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-item-label">Kekurangan</div>
                <div class="stat-item-value text-danger">
                    {{ $mapping['guru_penjas']['kurang'] ?? 0 }}
                </div>
            </div>

        </div>

        <div class="guru-list">

            @if($guruPenjas->count() > 0)

                @foreach($guruPenjas as $guru)

                    <div class="guru-item">
                        <div class="guru-avatar">
                            {{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}
                        </div>
                        <div class="guru-info">
                            <div class="guru-name">{{ $guru->nama_lengkap }}</div>
                            <div class="guru-nip">{{ $guru->nip }}</div>
                        </div>
                    </div>

                @endforeach

            @else

                @if(($mapping['guru_penjas']['kebutuhan'] ?? 0) > 0)
                    <div class="slot-kosong">
                        <i class="fas fa-user-slash"></i>
                        <span>Slot 1 - Kosong</span>
                    </div>
                @endif

            @endif

        </div>

    </div>

    <!-- Guru Agama -->
    <div class="formasi-block">

        <div class="formasi-header">
            <div>
                <div class="formasi-title">
                    <i class="fas fa-book-quran me-2 text-warning"></i>
                    Guru Agama SD
                </div>
            </div>
            <span class="formasi-badge {{ strtolower($mapping['guru_agama']['status'] ?? 'kosong') }}">
                {{ $mapping['guru_agama']['status'] ?? 'KOSONG' }}
            </span>
        </div>

        <div class="formasi-stats">

            <div class="stat-item">
                <div class="stat-item-label">Kebutuhan</div>
                <div class="stat-item-value text-info">
                    {{ $mapping['guru_agama']['kebutuhan'] ?? 0 }}
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-item-label">Yang Ada</div>
                <div class="stat-item-value text-success">
                    {{ $mapping['guru_agama']['ada'] ?? 0 }}
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-item-label">Kekurangan</div>
                <div class="stat-item-value text-danger">
                    {{ $mapping['guru_agama']['kurang'] ?? 0 }}
                </div>
            </div>

        </div>

        <div class="guru-list">

            @if($guruAgama->count() > 0)

                @foreach($guruAgama as $guru)

                    <div class="guru-item">
                        <div class="guru-avatar">
                            {{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}
                        </div>
                        <div class="guru-info">
                            <div class="guru-name">{{ $guru->nama_lengkap }}</div>
                            <div class="guru-nip">{{ $guru->nip }}</div>
                        </div>
                    </div>

                @endforeach

            @else

                @if(($mapping['guru_agama']['kebutuhan'] ?? 0) > 0)
                    <div class="slot-kosong">
                        <i class="fas fa-user-slash"></i>
                        <span>Slot 1 - Kosong</span>
                    </div>
                @endif

            @endif

        </div>

    </div>

</div>

@endsection
