@extends('layouts.admin')

@section('content')

<style>
    /* =============================================
       DETAIL KEBUTUHAN GURU — MINIMALIST THEME
       ============================================= */

    .page-header {
        position: sticky;
        top: 0;
        background: #f8fafc;
        z-index: 100;
        padding: 16px 0;
        margin-bottom: 24px;
        border-bottom: 1px solid #E2E8F0;
    }

    .card-custom {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    /* --- School Info Row --- */
    .school-info-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .info-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .info-label {
        font-size: 13px;
        color: #64748B;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
    }
    .info-value.text-primary { color: #2563EB !important; }

    /* --- Formasi Block --- */
    .formasi-header {
        padding: 16px 20px;
        border-bottom: 1px solid #E2E8F0;
        background: #F8FAFC;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .formasi-title {
        font-size: 15px;
        font-weight: 700;
        color: #1E293B;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .formasi-body {
        padding: 20px;
    }

    /* --- Ratio / Status Badge --- */
    .ratio-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .ratio-lengkap { background-color: #DCFCE7; color: #166534; border: 1px solid #bbf7d0; }
    .ratio-parsial { background-color: #FEF9C3; color: #854D0E; border: 1px solid #fef08a; }
    .ratio-kosong { background-color: #FEE2E2; color: #991B1B; border: 1px solid #fecaca; }

    /* --- Stats Grid (Kebutuhan / Ada / Kurang) --- */
    .formasi-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-item {
        text-align: center;
        padding: 12px;
        background: #F1F5F9;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
    }
    .stat-item-label {
        font-size: 12px;
        color: #475569;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .stat-item-value {
        font-size: 20px;
        font-weight: 700;
        color: #1E293B;
    }

    /* --- Guru List --- */
    .guru-list-title {
        font-size: 13px;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .guru-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 12px;
    }
    .guru-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        background: #fff;
        transition: border-color 0.15s;
    }
    .guru-item:hover {
        border-color: #93C5FD;
    }
    .guru-avatar {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #EFF6FF;
        color: #2563EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        margin-right: 14px;
    }
    .guru-info {
        flex: 1;
    }
    .guru-name {
        font-weight: 600;
        font-size: 14px;
        color: #0F172A;
        line-height: 1.3;
    }
    .guru-nip {
        font-size: 12px;
        color: #64748B;
        margin-top: 2px;
    }

    /* --- Badge Status ASN --- */
    .badge-asn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.03em;
        margin-top: 4px;
    }
    .badge-asn-pns { background-color: #0D9488; color: #fff; }
    .badge-asn-pppk { background-color: #2563EB; color: #fff; }
    .badge-asn-pppkw { background-color: #7C3AED; color: #fff; }
    .badge-asn-lain { background-color: #6B7280; color: #fff; }

    /* --- Breakdown Status Row --- */
    .breakdown-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 16px;
    }
    .breakdown-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        color: #334155;
    }
    .breakdown-chip .chip-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    .chip-dot-pns { background: #0D9488; }
    .chip-dot-pppk { background: #2563EB; }
    .chip-dot-pppkw { background: #7C3AED; }
    .chip-dot-lain { background: #6B7280; }
    .guru-action {
        margin-left: 10px;
    }
    .btn-detail-guru {
        color: #94A3B8;
        background: transparent;
        border: none;
        padding: 6px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.15s;
    }
    .btn-detail-guru:hover {
        color: #2563EB;
        background: #EFF6FF;
    }

    .slot-kosong {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border: 1px dashed #CBD5E1;
        border-radius: 8px;
        background: #F8FAFC;
        color: #94A3B8;
    }
    .slot-kosong-icon {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        font-size: 16px;
    }
    .slot-kosong-text {
        font-size: 13px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .school-info-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .school-info-row { grid-template-columns: 1fr; }
        .formasi-stats { grid-template-columns: 1fr; }
    }
</style>

<div class="container-fluid" style="padding-bottom:100px;">

    <!-- Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 style="font-weight:700; color:#1E293B; margin:0; font-size:20px;">Detail Kebutuhan Guru</h3>
                <p style="color:#64748B; margin:4px 0 0; font-size:14px;">
                    Analisis pemenuhan formasi di <strong style="color:#334155;">{{ $sekolah->nama }}</strong>
                </p>
            </div>
            <a href="{{ route('kebutuhan-guru.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size:13px; border-radius:6px;">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:8px; font-size:14px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Informasi Sekolah Row -->
    <div class="school-info-row">
        <div class="info-card">
            <div class="info-label">Kecamatan</div>
            <div class="info-value">{{ $sekolah->parent?->nama ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Jumlah Rombel</div>
            <div class="info-value text-primary">{{ $mapping['jumlah_rombel'] ?? 0 }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Status Keseluruhan</div>
            <div class="info-value">
                @php
                    $statusCls = strtolower($mapping['status'] ?? 'kosong');
                    $statusLabel = match($mapping['status'] ?? 'kosong') {
                        'LENGKAP' => 'Lengkap ✓',
                        'PARSIAL' => 'Parsial ⚠',
                        'KOSONG' => 'Kosong ✗',
                        default => 'Unknown'
                    };
                @endphp
                <span class="ratio-badge ratio-{{ $statusCls }}" style="font-size:13px; padding:6px 12px;">{{ $statusLabel }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-label">Total Guru Aktif</div>
            <div class="info-value text-success">
                {{ ($mapping['guru_kelas']['ada'] ?? 0) + ($mapping['guru_penjas']['ada'] ?? 0) + ($mapping['guru_agama']['ada'] ?? 0) }}
            </div>
        </div>
    </div>

    <!-- Guru Kelas SD -->
    <div class="card-custom">
        <div class="formasi-header">
            <div class="formasi-title">
                <i class="fas fa-chalkboard-user text-primary" style="font-size:18px;"></i>
                Guru Kelas SD
            </div>
            <span class="ratio-badge ratio-{{ strtolower($mapping['guru_kelas']['status'] ?? 'kosong') }}">
                Terisi: {{ $mapping['guru_kelas']['ada'] ?? 0 }} / {{ $mapping['guru_kelas']['kebutuhan'] ?? 0 }}
            </span>
        </div>
        
        <div class="formasi-body">
            <div class="formasi-stats">
                <div class="stat-item">
                    <div class="stat-item-label">Kebutuhan (Sesuai Rombel)</div>
                    <div class="stat-item-value text-primary">{{ $mapping['guru_kelas']['kebutuhan'] ?? 0 }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-label">Guru Terdata</div>
                    <div class="stat-item-value text-success">{{ $mapping['guru_kelas']['ada'] ?? 0 }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-label">Kekurangan</div>
                    <div class="stat-item-value text-danger">{{ $mapping['guru_kelas']['kurang'] ?? 0 }}</div>
                </div>
            </div>

            <div class="breakdown-row">
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pns"></span>PNS: {{ $breakdownKelas['PNS'] ?? 0 }}</span>
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pppk"></span>PPPK: {{ $breakdownKelas['PPPK'] ?? 0 }}</span>
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pppkw"></span>PPPK-PW: {{ $breakdownKelas['PPPK-PW'] ?? 0 }}</span>
                @if(($breakdownKelas['Lainnya'] ?? 0) > 0)
                    <span class="breakdown-chip"><span class="chip-dot chip-dot-lain"></span>Lainnya: {{ $breakdownKelas['Lainnya'] }}</span>
                @endif
            </div>

            <div class="guru-list-title">Daftar Guru Kelas</div>
            <div class="guru-grid">
                @if($guruKelas->count() > 0)
                    @foreach($guruKelas as $guru)
                        <div class="guru-item">
                            <div class="guru-avatar">
                                {{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}
                            </div>
                            <div class="guru-info">
                                <div class="guru-name">{{ $guru->nama_lengkap }}</div>
                                <div class="guru-nip">{{ $guru->nip ?: 'Non-ASN' }}</div>
                                @php
                                    $asn = strtoupper($guru->statusAsnData?->nama ?? '');
                                    if (str_contains($asn, 'PPPK-PW')) { $badgeAsn = 'badge-asn-pppkw'; $labelAsn = 'PPPK-PW'; }
                                    elseif (str_contains($asn, 'PPPK')) { $badgeAsn = 'badge-asn-pppk'; $labelAsn = 'PPPK'; }
                                    elseif (str_contains($asn, 'PNS')) { $badgeAsn = 'badge-asn-pns'; $labelAsn = 'PNS'; }
                                    else { $badgeAsn = 'badge-asn-lain'; $labelAsn = $asn ?: 'Non-ASN'; }
                                @endphp
                                <span class="badge-asn {{ $badgeAsn }}">{{ $labelAsn }}</span>
                            </div>
                            <div class="guru-action">
                                <a href="{{ route('pegawai.show', $guru->id) }}" target="_blank" class="btn-detail-guru" title="Lihat Profil Guru">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                @php
                    $slotKosongKelas = ($mapping['guru_kelas']['kebutuhan'] ?? 0) - ($mapping['guru_kelas']['ada'] ?? 0);
                @endphp
                @for($i = 0; $i < $slotKosongKelas; $i++)
                    <div class="slot-kosong">
                        <div class="slot-kosong-icon">
                            <i class="fas fa-user-slash"></i>
                        </div>
                        <div class="slot-kosong-text">Slot {{ ($mapping['guru_kelas']['ada'] ?? 0) + $i + 1 }} - Kosong</div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Guru Penjas SD -->
    <div class="card-custom">
        <div class="formasi-header">
            <div class="formasi-title">
                <i class="fas fa-person-hiking text-success" style="font-size:18px;"></i>
                Guru Pendidikan Jasmani
            </div>
            <span class="ratio-badge ratio-{{ strtolower($mapping['guru_penjas']['status'] ?? 'kosong') }}">
                Terisi: {{ $mapping['guru_penjas']['ada'] ?? 0 }} / {{ $mapping['guru_penjas']['kebutuhan'] ?? 0 }}
            </span>
        </div>
        
        <div class="formasi-body">
            <div class="formasi-stats">
                <div class="stat-item">
                    <div class="stat-item-label">Kebutuhan</div>
                    <div class="stat-item-value text-primary">{{ $mapping['guru_penjas']['kebutuhan'] ?? 0 }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-label">Guru Terdata</div>
                    <div class="stat-item-value text-success">{{ $mapping['guru_penjas']['ada'] ?? 0 }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-label">Kekurangan</div>
                    <div class="stat-item-value text-danger">{{ $mapping['guru_penjas']['kurang'] ?? 0 }}</div>
                </div>
            </div>

            <div class="breakdown-row">
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pns"></span>PNS: {{ $breakdownPenjas['PNS'] ?? 0 }}</span>
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pppk"></span>PPPK: {{ $breakdownPenjas['PPPK'] ?? 0 }}</span>
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pppkw"></span>PPPK-PW: {{ $breakdownPenjas['PPPK-PW'] ?? 0 }}</span>
                @if(($breakdownPenjas['Lainnya'] ?? 0) > 0)
                    <span class="breakdown-chip"><span class="chip-dot chip-dot-lain"></span>Lainnya: {{ $breakdownPenjas['Lainnya'] }}</span>
                @endif
            </div>

            <div class="guru-list-title">Daftar Guru Penjas</div>
            <div class="guru-grid">
                @if($guruPenjas->count() > 0)
                    @foreach($guruPenjas as $guru)
                        <div class="guru-item">
                            <div class="guru-avatar" style="background:#DCFCE7; color:#16A34A;">
                                {{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}
                            </div>
                            <div class="guru-info">
                                <div class="guru-name">{{ $guru->nama_lengkap }}</div>
                                <div class="guru-nip">{{ $guru->nip ?: 'Non-ASN' }}</div>
                                @php
                                    $asn = strtoupper($guru->statusAsnData?->nama ?? '');
                                    if (str_contains($asn, 'PPPK-PW')) { $badgeAsn = 'badge-asn-pppkw'; $labelAsn = 'PPPK-PW'; }
                                    elseif (str_contains($asn, 'PPPK')) { $badgeAsn = 'badge-asn-pppk'; $labelAsn = 'PPPK'; }
                                    elseif (str_contains($asn, 'PNS')) { $badgeAsn = 'badge-asn-pns'; $labelAsn = 'PNS'; }
                                    else { $badgeAsn = 'badge-asn-lain'; $labelAsn = $asn ?: 'Non-ASN'; }
                                @endphp
                                <span class="badge-asn {{ $badgeAsn }}">{{ $labelAsn }}</span>
                            </div>
                            <div class="guru-action">
                                <a href="{{ route('pegawai.show', $guru->id) }}" target="_blank" class="btn-detail-guru" title="Lihat Profil Guru">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    @if(($mapping['guru_penjas']['kebutuhan'] ?? 0) > 0)
                        <div class="slot-kosong">
                            <div class="slot-kosong-icon">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <div class="slot-kosong-text">Slot 1 - Kosong</div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Guru Agama SD -->
    <div class="card-custom">
        <div class="formasi-header">
            <div class="formasi-title">
                <i class="fas fa-book-quran text-warning" style="font-size:18px;"></i>
                Guru Agama SD
            </div>
            <span class="ratio-badge ratio-{{ strtolower($mapping['guru_agama']['status'] ?? 'kosong') }}">
                Terisi: {{ $mapping['guru_agama']['ada'] ?? 0 }} / {{ $mapping['guru_agama']['kebutuhan'] ?? 0 }}
            </span>
        </div>
        
        <div class="formasi-body">
            <div class="formasi-stats">
                <div class="stat-item">
                    <div class="stat-item-label">Kebutuhan</div>
                    <div class="stat-item-value text-primary">{{ $mapping['guru_agama']['kebutuhan'] ?? 0 }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-label">Guru Terdata</div>
                    <div class="stat-item-value text-success">{{ $mapping['guru_agama']['ada'] ?? 0 }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-label">Kekurangan</div>
                    <div class="stat-item-value text-danger">{{ $mapping['guru_agama']['kurang'] ?? 0 }}</div>
                </div>
            </div>

            <div class="breakdown-row">
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pns"></span>PNS: {{ $breakdownAgama['PNS'] ?? 0 }}</span>
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pppk"></span>PPPK: {{ $breakdownAgama['PPPK'] ?? 0 }}</span>
                <span class="breakdown-chip"><span class="chip-dot chip-dot-pppkw"></span>PPPK-PW: {{ $breakdownAgama['PPPK-PW'] ?? 0 }}</span>
                @if(($breakdownAgama['Lainnya'] ?? 0) > 0)
                    <span class="breakdown-chip"><span class="chip-dot chip-dot-lain"></span>Lainnya: {{ $breakdownAgama['Lainnya'] }}</span>
                @endif
            </div>

            <div class="guru-list-title">Daftar Guru Agama</div>
            <div class="guru-grid">
                @if($guruAgama->count() > 0)
                    @foreach($guruAgama as $guru)
                        <div class="guru-item">
                            <div class="guru-avatar" style="background:#FEF9C3; color:#D97706;">
                                {{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}
                            </div>
                            <div class="guru-info">
                                <div class="guru-name">{{ $guru->nama_lengkap }}</div>
                                <div class="guru-nip">{{ $guru->nip ?: 'Non-ASN' }}</div>
                                @php
                                    $asn = strtoupper($guru->statusAsnData?->nama ?? '');
                                    if (str_contains($asn, 'PPPK-PW')) { $badgeAsn = 'badge-asn-pppkw'; $labelAsn = 'PPPK-PW'; }
                                    elseif (str_contains($asn, 'PPPK')) { $badgeAsn = 'badge-asn-pppk'; $labelAsn = 'PPPK'; }
                                    elseif (str_contains($asn, 'PNS')) { $badgeAsn = 'badge-asn-pns'; $labelAsn = 'PNS'; }
                                    else { $badgeAsn = 'badge-asn-lain'; $labelAsn = $asn ?: 'Non-ASN'; }
                                @endphp
                                <span class="badge-asn {{ $badgeAsn }}">{{ $labelAsn }}</span>
                            </div>
                            <div class="guru-action">
                                <a href="{{ route('pegawai.show', $guru->id) }}" target="_blank" class="btn-detail-guru" title="Lihat Profil Guru">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    @if(($mapping['guru_agama']['kebutuhan'] ?? 0) > 0)
                        <div class="slot-kosong">
                            <div class="slot-kosong-icon">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <div class="slot-kosong-text">Slot 1 - Kosong</div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

</div>

@endsection
