@extends('layouts.admin')

@section('content')

<style>
    /* =============================================
       KEBUTUHAN GURU — REDESIGN SESUAI TEMA MINIMALIS
       ============================================= */

    /* --- Wrapper Card --- */
    .pegawai-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    /* --- Toolbar atas tabel --- */
    .table-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 20px;
        border-bottom: 1px solid #E2E8F0;
        background: #fff;
    }
    .table-toolbar-title {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
    }

    /* --- Tabel utama --- */
    .pegawai-table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Header */
    .pegawai-table thead tr {
        background: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
    }
    .pegawai-table thead th {
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px;
        border: none;
        white-space: nowrap;
    }

    /* Body rows */
    .pegawai-table tbody tr {
        border-bottom: 1px solid #E2E8F0;
        transition: background 0.1s ease;
    }
    .pegawai-table tbody tr:last-child { border-bottom: none; }
    .pegawai-table tbody tr:hover { background: #F8FAFC; }
    .pegawai-table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: #374151;
        border: none;
        vertical-align: middle;
    }

    /* --- Teks Sekolah --- */
    .nama-teks {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        line-height: 1.3;
    }
    .sub-teks {
        font-size: 12px;
        font-weight: 400;
        color: #9CA3AF;
        margin-top: 2px;
    }

    /* --- Ratio Badge (X/Y) --- */
    .ratio-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.5px;
        min-width: 50px;
    }
    .ratio-lengkap { background-color: #DCFCE7; color: #166534; }
    .ratio-parsial { background-color: #FEF9C3; color: #854D0E; }
    .ratio-kosong { background-color: #FEE2E2; color: #991B1B; }

    /* --- Status Badge --- */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .badge-status.bg-success { background: #16A34A !important; color: #fff; }
    .badge-status.bg-warning { background: #F59E0B !important; color: #fff; }
    .badge-status.bg-danger { background: #EF4444 !important; color: #fff; }

    /* --- Tombol Aksi --- */
    .btn-aksi {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid;
        background: transparent;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, transform 0.1s;
        padding: 0;
    }
    .btn-aksi:hover { transform: scale(1.05); }
    .btn-aksi-detail { border-color: #93C5FD; color: #3B82F6; }
    .btn-aksi-detail:hover { background: #EFF6FF; color: #2563EB; }

    /* --- Stats Card Minimalis --- */
    .stats-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: transform 0.2s;
    }
    .stats-card:hover { transform: translateY(-2px); }
    .stats-title { font-size: 13px; color: #64748B; font-weight: 500; margin-bottom: 4px; }
    .stats-value { font-size: 24px; font-weight: 700; color: #0F172A; }
    .stats-value.text-primary { color: #2563EB !important; }
    .stats-value.text-success { color: #16A34A !important; }
    .stats-value.text-warning { color: #D97706 !important; }
    .stats-value.text-danger { color: #DC2626 !important; }

    /* --- Pagination Minimal --- */
    .pagination-minimal {
        display: flex;
        align-items: center;
        gap: 2px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .page-link-minimal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 6px;
        border-radius: 6px;
        font-size: 13px;
        color: #374151;
        text-decoration: none;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: background 0.12s;
    }
    .page-link-minimal:hover { background: #F1F5F9; color: #111827; }
    .page-item-minimal.active .page-link-minimal {
        font-weight: 700;
        color: #111827;
        background: #F1F5F9;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .page-item-minimal.disabled .page-link-minimal { color: #CBD5E1; cursor: not-allowed; }
    .page-link-minimal.ellipsis { cursor: default; }
    .page-link-minimal.ellipsis:hover { background: transparent; }

    /* --- Empty State --- */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        color: #9CA3AF;
    }
    .empty-state i { font-size: 2.5rem; margin-bottom: 12px; color: #CBD5E1; }
    .empty-state p { font-size: 14px; margin: 0 0 16px; }

    @media (max-width: 991px) {
        .col-hide-tablet { display: none !important; }
    }
</style>

<div class="container-fluid" style="padding-bottom:100px;">
    
    <!-- Title -->
    <div style="margin-bottom:24px;">
        <h4 style="font-weight:700; color:#1E293B; margin:0; font-size:20px; display:flex; align-items:center; gap:8px;">
            Kebutuhan Guru per Sekolah
        </h4>
        <p style="color:#64748B; margin:4px 0 0; font-size:14px;">Pemetaan pemenuhan formasi guru berdasarkan jumlah rombel</p>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:8px; font-size:14px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistik Card Row -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stats-card">
                <div class="stats-title">Total Sekolah (SD/SMP)</div>
                <div class="stats-value text-primary">{{ $statistik['total_sekolah'] }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stats-card">
                <div class="stats-title">Sekolah Lengkap</div>
                <div class="stats-value text-success">{{ $statistik['sekolah_lengkap'] }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stats-card">
                <div class="stats-title">Sekolah Parsial</div>
                <div class="stats-value text-warning">{{ $statistik['sekolah_parsial'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-title">Sekolah Kosong</div>
                <div class="stats-value text-danger">{{ $statistik['sekolah_kosong'] }}</div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="pegawai-card">
        <div class="table-toolbar" style="flex-wrap: wrap; gap: 12px;">
            <span class="table-toolbar-title" style="flex:1;">
                <i class="fas fa-chart-pie me-2" style="color:#94A3B8;"></i>
                Pemetaan Formasi
            </span>
            <form id="filterForm" method="GET" action="{{ route('kebutuhan-guru.index') }}" style="margin:0; display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                
                {{-- Pencarian --}}
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94A3B8; font-size: 13px;"></i>
                    <input type="text" id="searchInput" name="search" value="{{ $filterSearch ?? '' }}" placeholder="Cari sekolah..." class="form-control" style="padding-left: 32px; font-size: 13px; min-width: 220px;">
                </div>

                {{-- Dropdown Kecamatan --}}
                <select name="kecamatan" class="form-select" style="width: auto; min-width: 200px; font-size: 13px;" onchange="this.form.submit()">
                    <option value="">-- Semua Kecamatan --</option>
                    @foreach($unitKerjaLevel2 as $uk)
                        <option value="{{ $uk->id }}" {{ $filterKecamatan == $uk->id ? 'selected' : '' }}>
                            {{ $uk->nama }}
                        </option>
                    @endforeach
                </select>

                {{-- Dropdown Status --}}
                <select name="status" class="form-select" style="width: auto; min-width: 160px; font-size: 13px;" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="LENGKAP" {{ $filterStatus == 'LENGKAP' ? 'selected' : '' }}>Lengkap</option>
                    <option value="PARSIAL" {{ $filterStatus == 'PARSIAL' ? 'selected' : '' }}>Parsial</option>
                    <option value="KOSONG" {{ $filterStatus == 'KOSONG' ? 'selected' : '' }}>Kosong</option>
                </select>

                @if($filterKecamatan || $filterStatus || !empty($filterSearch))
                    <a href="{{ route('kebutuhan-guru.index') }}" class="btn btn-sm btn-outline-secondary" style="font-size: 13px; height: 36px; display:flex; align-items:center;">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>

        @if($sekolahList->count() > 0)
            <div class="table-responsive">
                <table class="pegawai-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            @if(!$filterKecamatan)
                                <th class="col-hide-tablet">Kecamatan</th>
                            @endif
                            <th>Nama Sekolah</th>
                            <th style="text-align: center;">Rombel</th>
                            <th style="text-align: center;">Guru Kelas</th>
                            <th style="text-align: center;">Guru Penjas</th>
                            <th style="text-align: center;">Guru Agama</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sekolahList as $sekolah)
                            @php
                                $mapping = $mappingData[$sekolah->id] ?? null;
                                if (!$mapping) continue;
                            @endphp
                            <tr>
                                <td style="text-align: center; color: #64748B;">{{ $sekolahList->firstItem() + $loop->index }}</td>
                                
                                @if(!$filterKecamatan)
                                    <td class="col-hide-tablet" style="color: #475569;">
                                        {{ $sekolah->parent?->nama ?? '-' }}
                                    </td>
                                @endif

                                <td>
                                    <div class="nama-teks">{{ $sekolah->nama }}</div>
                                </td>

                                <td style="text-align: center;">
                                    <span style="background: #F1F5F9; color: #475569; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                        {{ $mapping['jumlah_rombel'] ?? 0 }}
                                    </span>
                                </td>

                                <td style="text-align: center;">
                                    <span class="ratio-badge ratio-{{ strtolower($mapping['guru_kelas']['status'] ?? 'kosong') }}" title="Ada: {{ $mapping['guru_kelas']['ada'] ?? 0 }}, Butuh: {{ $mapping['guru_kelas']['kebutuhan'] ?? 0 }}">
                                        {{ $mapping['guru_kelas']['ada'] ?? 0 }} / {{ $mapping['guru_kelas']['kebutuhan'] ?? 0 }}
                                    </span>
                                </td>

                                <td style="text-align: center;">
                                    <span class="ratio-badge ratio-{{ strtolower($mapping['guru_penjas']['status'] ?? 'kosong') }}" title="Ada: {{ $mapping['guru_penjas']['ada'] ?? 0 }}, Butuh: {{ $mapping['guru_penjas']['kebutuhan'] ?? 0 }}">
                                        {{ $mapping['guru_penjas']['ada'] ?? 0 }} / {{ $mapping['guru_penjas']['kebutuhan'] ?? 0 }}
                                    </span>
                                </td>

                                <td style="text-align: center;">
                                    <span class="ratio-badge ratio-{{ strtolower($mapping['guru_agama']['status'] ?? 'kosong') }}" title="Ada: {{ $mapping['guru_agama']['ada'] ?? 0 }}, Butuh: {{ $mapping['guru_agama']['kebutuhan'] ?? 0 }}">
                                        {{ $mapping['guru_agama']['ada'] ?? 0 }} / {{ $mapping['guru_agama']['kebutuhan'] ?? 0 }}
                                    </span>
                                </td>

                                <td style="text-align: center;">
                                    @php
                                        $statusBadge = match($mapping['status'] ?? 'kosong') {
                                            'LENGKAP' => ['bg-success', 'Lengkap'],
                                            'PARSIAL' => ['bg-warning', 'Parsial'],
                                            'KOSONG' => ['bg-danger', 'Kosong'],
                                            default => ['bg-secondary', 'Unknown']
                                        };
                                    @endphp
                                    <span class="badge-status {{ $statusBadge[0] }}">
                                        @if($statusBadge[1] == 'Lengkap') <i class="fas fa-check-circle"></i> 
                                        @elseif($statusBadge[1] == 'Parsial') <i class="fas fa-exclamation-circle"></i>
                                        @else <i class="fas fa-times-circle"></i> @endif
                                        {{ $statusBadge[1] }}
                                    </span>
                                </td>

                                <td style="text-align: center;">
                                    <a href="{{ route('kebutuhan-guru.show', $sekolah->id) }}" class="btn-aksi btn-aksi-detail" title="Lihat Detail Pemetaan">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox" style="font-size:3rem; color:#CBD5E1; margin-bottom:16px;"></i>
                <p style="font-size:15px; color:#6B7280; margin-bottom:20px;">Belum ada data atau tidak ada sekolah yang sesuai dengan filter.</p>
                @if($filterKecamatan || $filterStatus)
                    <a href="{{ route('kebutuhan-guru.index') }}" class="btn btn-sm" style="border:1px solid #E2E8F0; color:#374151; font-size:13px; border-radius:7px; padding:8px 16px;">
                        <i class="fas fa-times me-1"></i> Hapus Filter
                    </a>
                @endif
            </div>
        @endif
    </div>

    @if ($sekolahList->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3 px-1">
            <div style="font-size:13px; color:#6B7280;">
                Menampilkan <strong style="color:#374151;">{{ $sekolahList->firstItem() ?? 0 }}</strong>–<strong style="color:#374151;">{{ $sekolahList->lastItem() ?? 0 }}</strong>
                dari <strong style="color:#374151;">{{ $sekolahList->total() }}</strong> sekolah
            </div>
            {{ $sekolahList->links('pagination.minimal') }}
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let timeout = null;
        const searchInput = document.getElementById('searchInput');
        const filterForm = document.getElementById('filterForm');

        if(searchInput) {
            searchInput.addEventListener('input', function (e) {
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    filterForm.submit();
                }, 800); // Tunggu sampai user selesai mengetik (800ms)
            });
            
            // Pindahkan kursor ke ujung teks jika ada valuenya agar user bisa lanjut mengetik setelah reload
            if(searchInput.value) {
                const len = searchInput.value.length;
                searchInput.focus();
                searchInput.setSelectionRange(len, len);
            }
        }
    });
</script>
@endpush
