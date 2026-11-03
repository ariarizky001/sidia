@extends('layouts.admin')

@section('content')

<style>
    /* =============================================
       DATA SEKOLAH TABLE — REDESIGN SESUAI DATA PEGAWAI
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
    .search-wrapper {
        position: relative;
    }
    .search-wrapper i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        font-size: 13px;
    }
    .search-input {
        padding: 7px 12px 7px 32px;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        font-size: 13px;
        color: #374151;
        background: #F8FAFC;
        width: 240px;
        outline: none;
        transition: border-color 0.15s, background 0.15s;
    }
    .search-input:focus {
        border-color: #93C5FD;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.2);
    }
    .search-input::placeholder { color: #9CA3AF; }

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
    .pegawai-table thead th.th-aksi {
        text-align: right;
        padding-right: 20px;
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

    /* --- Nama --- */
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

    /* --- Tombol Aksi 28×28px --- */
    .aksi-group {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 5px;
        padding-right: 4px;
    }
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

    /* --- Responsivitas --- */
    @media (max-width: 991px) {
        .col-hide-tablet { display: none !important; }
    }
    @media (max-width: 575px) {
        .col-hide-mobile { display: none !important; }
        .search-input { width: 180px; }
    }
</style>

<div class="container-fluid" style="padding-bottom:100px;">
    <!-- Title -->
    <div style="margin-bottom:24px;">
        <h4 style="font-weight:700; color:#1E293B; margin:0; font-size:20px; display:flex; align-items:center; gap:8px;">
            Data Sekolah
        </h4>
        <p style="color:#64748B; margin:4px 0 0; font-size:14px;">Lihat data sekolah dan pegawai yang terdata di setiap sekolah</p>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:8px; font-size:14px;">
            <i class="fas fa-check-circle me-2"></i><strong>Berhasil!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius:8px; font-size:14px;">
            <i class="fas fa-exclamation-circle me-2"></i><strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="pegawai-card">
        <div class="table-toolbar" style="flex-wrap: wrap; gap: 12px;">
            <span class="table-toolbar-title" style="flex:1;">
                <i class="fas fa-school me-2" style="color:#94A3B8;"></i>
                Daftar Sekolah
            </span>
            <form method="GET" action="{{ route('data-sekolah.index') }}" style="margin:0; display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                {{-- Dropdown Filter Unit Kerja 2 --}}
                <select name="unit_kerja_2_id" class="form-select" style="width: auto; min-width: 200px; font-size: 13px;" onchange="this.form.submit()">
                    <option value="">-- Semua Kecamatan (Unit Kerja 2) --</option>
                    @foreach ($unitKerja2 as $uk)
                        <option value="{{ $uk->id }}" {{ $selectedUK2 == $uk->id ? 'selected' : '' }}>
                            {{ $uk->nama }}
                        </option>
                    @endforeach
                </select>

                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="search-input" placeholder="Cari nama sekolah (Enter)..." value="{{ $search }}" autocomplete="off">
                </div>
            </form>
        </div>

        @if ($sekolah->count() > 0)
            <div class="table-responsive">
                <table class="pegawai-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Nama Sekolah</th>
                            <th class="col-hide-mobile">Kecamatan</th>
                            <th style="text-align: center;">Jumlah Pegawai</th>
                            <th class="th-aksi" style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sekolah as $index => $item)
                            @php
                                $countPegawai = \App\Models\Pegawai::where(function($q) use ($item) {
                                    $q->where('unit_kerja_1_id', $item->id)
                                      ->orWhere('unit_kerja_2_id', $item->id)
                                      ->orWhere('unit_kerja_3_id', $item->id);
                                })->count();
                            @endphp
                            <tr>
                                <td style="text-align: center; color: #64748B;">{{ $sekolah->firstItem() + $index }}</td>
                                <td>
                                    <div class="nama-teks">{{ $item->nama }}</div>
                                </td>
                                <td class="col-hide-mobile" style="color: #475569;">
                                    {{ $item->parent ? $item->parent->nama : '-' }}
                                </td>
                                <td style="text-align: center;">
                                    <span style="background: #F1F5F9; color: #475569; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                        {{ $countPegawai }} Pegawai
                                    </span>
                                </td>
                                <td>
                                    <div class="aksi-group">
                                        <a href="{{ route('data-sekolah.show', $item->id) }}" class="btn-aksi btn-aksi-detail" title="Lihat Data Pegawai Sekolah">
                                            <i class="fas fa-users"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-school" style="font-size:3rem; color:#CBD5E1; margin-bottom:16px;"></i>
                @if(request('search') || request('unit_kerja_2_id'))
                    <p style="font-size:15px; color:#6B7280; margin-bottom:20px;">Tidak ditemukan data sekolah dengan filter tersebut</p>
                    <a href="{{ route('data-sekolah.index') }}" class="btn btn-sm" style="border:1px solid #E2E8F0; color:#374151; font-size:13px; border-radius:7px; padding:8px 16px;">
                        <i class="fas fa-times me-1"></i> Hapus Filter
                    </a>
                @else
                    <p style="font-size:15px; color:#6B7280; margin-bottom:20px;">Belum ada data sekolah di sistem</p>
                @endif
            </div>
        @endif
    </div>

    @if ($sekolah->count() > 0)
        @if (request('search') || request('unit_kerja_2_id'))
            <div style="font-size:13px;color:#6B7280; margin-top:12px;">
                Hasil pencarian / filter —
                <a href="{{ route('data-sekolah.index') }}" style="color:#3B82F6;font-size:13px;">Hapus filter</a>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-3 px-1">
            <div style="font-size:13px; color:#6B7280;">
                Menampilkan <strong style="color:#374151;">{{ $sekolah->firstItem() ?? 0 }}</strong>–<strong style="color:#374151;">{{ $sekolah->lastItem() ?? 0 }}</strong>
                dari <strong style="color:#374151;">{{ $sekolah->total() }}</strong> sekolah
            </div>
            {{ $sekolah->links('pagination.minimal') }}
        </div>
    @endif

</div>
@endsection
