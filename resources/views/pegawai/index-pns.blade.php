@extends('layouts.admin')

@section('content')

<style>
    /* =============================================
       PEGAWAI TABLE — REDESIGN SESUAI PRD v1.0
       ============================================= */
    .pegawai-card { background:#fff; border:1px solid #E2E8F0; border-radius:10px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
    .table-toolbar { display:flex; justify-content:space-between; align-items:center; padding:14px 20px; border-bottom:1px solid #E2E8F0; background:#fff; }
    .table-toolbar-title { font-size:14px; font-weight:600; color:#334155; }
    .search-wrapper { position:relative; }
    .search-wrapper i { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#9CA3AF; font-size:13px; }
    .search-input { padding:7px 12px 7px 32px; border:1px solid #E2E8F0; border-radius:6px; font-size:13px; color:#374151; background:#F8FAFC; width:240px; outline:none; transition:border-color 0.15s, background 0.15s; }
    .search-input:focus { border-color:#93C5FD; background:#fff; box-shadow:0 0 0 3px rgba(147,197,253,0.2); }
    .search-input::placeholder { color:#9CA3AF; }
    .pegawai-table { width:100%; border-collapse:collapse; }
    .pegawai-table thead tr { background:#F8FAFC; border-bottom:1px solid #E2E8F0; }
    .pegawai-table thead th { font-size:12px; font-weight:700; color:#334155; text-transform:uppercase; letter-spacing:0.05em; padding:12px 16px; border:none; white-space:nowrap; }
    .pegawai-table thead th.th-aksi { text-align:right; padding-right:20px; }
    .pegawai-table tbody tr { border-bottom:1px solid #E2E8F0; transition:background 0.1s ease; }
    .pegawai-table tbody tr:last-child { border-bottom:none; }
    .pegawai-table tbody tr:hover { background:#F8FAFC; }
    .pegawai-table tbody td { padding:14px 16px; font-size:14px; color:#374151; border:none; vertical-align:middle; }
    .nip-link { font-size:13px; font-weight:500; color:#3B82F6; text-decoration:none; font-family:'Courier New',monospace; letter-spacing:0.02em; }
    .nip-link:hover { text-decoration:underline; color:#2563EB; }
    .nama-pegawai { font-size:14px; font-weight:600; color:#111827; line-height:1.3; }
    .tgl-lahir { font-size:12px; font-weight:400; color:#9CA3AF; margin-top:2px; }
    .jabatan-text { font-size:13px; color:#374151; text-transform:uppercase; max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .badge-asn { display:inline-flex; align-items:center; padding:3px 9px; border-radius:4px; font-size:11px; font-weight:600; letter-spacing:0.03em; white-space:nowrap; }
    .badge-pns     { background:#0D9488; color:#fff; }
    .badge-pppk    { background:#2563EB; color:#fff; }
    .badge-honorer { background:#7C3AED; color:#fff; }
    .badge-asn-lain{ background:#64748B; color:#fff; }
    .badge-aktif    { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:4px; font-size:11px; font-weight:600; background:#16A34A; color:#fff; }
    .badge-nonaktif { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:4px; font-size:11px; font-weight:600; background:#6B7280; color:#fff; }
    .badge-dot { width:5px; height:5px; border-radius:50%; background:rgba(255,255,255,0.7); display:inline-block; }
    .aksi-group { display:flex; align-items:center; justify-content:flex-end; gap:5px; padding-right:4px; }
    .btn-aksi { width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; border:1px solid; background:transparent; font-size:12px; cursor:pointer; text-decoration:none; transition:background 0.15s, transform 0.1s; padding:0; }
    .btn-aksi:hover { transform:scale(1.05); }
    .btn-aksi-detail { border-color:#93C5FD; color:#3B82F6; }
    .btn-aksi-detail:hover { background:#EFF6FF; color:#2563EB; }
    .btn-aksi-edit   { border-color:#FCD34D; color:#D97706; }
    .btn-aksi-edit:hover { background:#FFFBEB; color:#B45309; }
    .btn-aksi-hapus  { border-color:#FCA5A5; color:#EF4444; }
    .btn-aksi-hapus:hover { background:#FEF2F2; color:#B91C1C; }
    .pagination-minimal { display:flex; align-items:center; gap:2px; list-style:none; margin:0; padding:0; }
    .page-link-minimal { display:inline-flex; align-items:center; justify-content:center; min-width:32px; height:32px; padding:0 6px; border-radius:6px; font-size:13px; color:#374151; text-decoration:none; border:none; background:transparent; cursor:pointer; transition:background 0.12s; }
    .page-link-minimal:hover { background:#F1F5F9; color:#111827; }
    .page-item-minimal.active .page-link-minimal { font-weight:700; color:#111827; background:#F1F5F9; text-decoration:underline; text-underline-offset:3px; }
    .page-item-minimal.disabled .page-link-minimal { color:#CBD5E1; cursor:not-allowed; }
    .page-link-minimal.ellipsis { cursor:default; }
    .page-link-minimal.ellipsis:hover { background:transparent; }
    .empty-state { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:60px 20px; color:#9CA3AF; }
    .empty-state i { font-size:2.5rem; margin-bottom:12px; color:#CBD5E1; }
    .empty-state p { font-size:14px; margin:0 0 16px; }
    @media (max-width:991px) { .col-hide-tablet { display:none !important; } }
    @media (max-width:575px) { .col-hide-mobile { display:none !important; } .search-input { width:180px; } }
    .modal-hapus-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:9999; align-items:center; justify-content:center; }
    .modal-hapus-overlay.show { display:flex; }
    .modal-hapus-box { background:#fff; border-radius:12px; padding:28px 32px; width:380px; max-width:90vw; box-shadow:0 10px 40px rgba(0,0,0,0.15); animation:fadeInUp 0.18s ease; }
    @keyframes fadeInUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .modal-hapus-icon { width:48px; height:48px; border-radius:50%; background:#FEF2F2; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
    .modal-hapus-icon i { color:#EF4444; font-size:20px; }
    .modal-hapus-title { font-size:16px; font-weight:700; color:#111827; text-align:center; margin-bottom:8px; }
    .modal-hapus-body  { font-size:14px; color:#6B7280; text-align:center; margin-bottom:24px; }
    .modal-hapus-nama  { font-weight:600; color:#374151; }
    .modal-hapus-actions { display:flex; gap:10px; }
    .btn-cancel-hapus { flex:1; padding:9px; border-radius:7px; border:1px solid #E2E8F0; background:#fff; font-size:14px; font-weight:500; color:#374151; cursor:pointer; transition:background 0.12s; }
    .btn-cancel-hapus:hover { background:#F8FAFC; }
    .btn-confirm-hapus { flex:1; padding:9px; border-radius:7px; border:none; background:#EF4444; font-size:14px; font-weight:600; color:#fff; cursor:pointer; transition:background 0.12s; }
    .btn-confirm-hapus:hover { background:#DC2626; }
</style>

<div class="container-fluid px-0">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
        <div>
            <h5 class="fw-bold text-dark mb-0" style="font-size:18px;">Data Pegawai PNS</h5>
            <p class="text-muted mb-0" style="font-size:13px;">Daftar pegawai dengan status Pegawai Negeri Sipil</p>
        </div>
        <a href="{{ route('pegawai.index') }}" class="btn btn-sm" style="border:1px solid #E2E8F0; color:#374151; font-size:13px; border-radius:7px; padding:7px 14px;">
            <i class="fas fa-arrow-left me-1"></i> Semua Pegawai
        </a>
    </div>

    {{-- Alerts --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:8px;font-size:14px;">
            <i class="fas fa-check-circle me-2"></i><strong>Berhasil!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius:8px;font-size:14px;">
            <i class="fas fa-exclamation-circle me-2"></i><strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="pegawai-card">
        {{-- Toolbar --}}
        <div class="table-toolbar">
            <span class="table-toolbar-title">
                <i class="fas fa-id-card me-2" style="color:#0D9488;"></i>
                Pegawai PNS
                <span style="background:#F0FDF4;color:#16A34A;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;margin-left:8px;">{{ $pegawai->total() }} orang</span>
            </span>
            <form method="GET" action="{{ route('pegawai.pns') }}" id="searchForm" style="margin:0;">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" id="searchPegawai" class="search-input" placeholder="Cari nama atau NIP (Enter)..." value="{{ request('search') }}" autocomplete="off">
                </div>
            </form>
        </div>

        @if ($pegawai->count() > 0)
            {{-- Table --}}
            <div class="table-responsive">
                <table class="pegawai-table" id="pegawaiTable">
                    <thead>
                        <tr>
                            <th style="width:160px;">NIP</th>
                            <th>Nama Lengkap</th>
                            <th class="col-hide-mobile">Status ASN</th>
                            <th class="col-hide-tablet">Golongan</th>
                            <th class="col-hide-tablet">Jabatan</th>
                            <th>Status</th>
                            <th class="th-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pegawaiTableBody">
                        @foreach ($pegawai as $item)
                            <tr>
                                <td><a href="{{ route('pegawai.show', $item->id) }}" class="nip-link">{{ $item->nip }}</a></td>
                                <td>
                                    <div class="nama-pegawai">{{ $item->nama_lengkap }}</div>
                                    <div class="tgl-lahir">{{ $item->tgl_lahir?->format('d M Y') ?? '-' }}</div>
                                </td>
                                <td class="col-hide-mobile"><span class="badge-asn badge-pns">PNS</span></td>
                                <td class="col-hide-tablet">{{ $item->golonganData?->kode ?? '-' }}</td>
                                <td class="col-hide-tablet">
                                    <span class="jabatan-text" title="{{ $item->jabatanData?->nama_jabatan ?? '-' }}">
                                        {{ $item->jabatanData?->nama_jabatan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($item->status_aktif === 'aktif')
                                        <span class="badge-aktif"><span class="badge-dot"></span> Aktif</span>
                                    @else
                                        <span class="badge-nonaktif"><span class="badge-dot"></span> Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="aksi-group">
                                        <a href="{{ route('pegawai.show', $item->id) }}" class="btn-aksi btn-aksi-detail" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('pegawai.edit', $item->id) }}" class="btn-aksi btn-aksi-edit" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                        <button type="button" class="btn-aksi btn-aksi-hapus" title="Hapus" onclick="konfirmasiHapus({{ $item->id }}, '{{ addslashes($item->nama_lengkap) }}')"><i class="fas fa-trash"></i></button>
                                        <form id="form-hapus-{{ $item->id }}" method="POST" action="{{ route('pegawai.destroy', $item->id) }}" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                @if(request('search'))
                    <i class="fas fa-search" style="font-size:3rem; color:#CBD5E1; margin-bottom:16px;"></i>
                    <p style="font-size:15px; color:#6B7280; margin-bottom:20px;">Tidak ditemukan data pegawai PNS untuk pencarian <strong>"{{ request('search') }}"</strong></p>
                    <a href="{{ route('pegawai.pns') }}" class="btn btn-sm" style="border:1px solid #E2E8F0; color:#374151; font-size:13px; border-radius:7px; padding:8px 16px;">
                        <i class="fas fa-times me-1"></i> Hapus Pencarian
                    </a>
                @else
                    <i class="fas fa-id-card" style="font-size:3rem; color:#CBD5E1; margin-bottom:16px;"></i>
                    <p style="font-size:15px; color:#6B7280; margin-bottom:20px;">Belum ada data pegawai PNS</p>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-sm" style="border:1px solid #E2E8F0; color:#374151; font-size:13px; border-radius:7px; padding:8px 16px;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Semua Pegawai
                    </a>
                @endif
            </div>
        @endif
    </div>

    @if ($pegawai->count() > 0)
        @if (request('search'))
            <div style="font-size:13px;color:#6B7280; margin-top:12px;">
                Hasil pencarian <strong style="color:#374151;">"{{ request('search') }}"</strong> —
                <a href="{{ route('pegawai.pns') }}" style="color:#3B82F6;font-size:13px;">Hapus filter</a>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-3 px-1">
            <div style="font-size:13px;color:#6B7280;">
                Menampilkan <strong style="color:#374151;">{{ $pegawai->firstItem() ?? 0 }}</strong>–<strong style="color:#374151;">{{ $pegawai->lastItem() ?? 0 }}</strong>
                dari <strong style="color:#374151;">{{ $pegawai->total() }}</strong> pegawai PNS
            </div>
            {{ $pegawai->links('pagination.minimal') }}
        </div>
    @endif

</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-hapus-overlay" id="modalHapus">
    <div class="modal-hapus-box">
        <div class="modal-hapus-icon"><i class="fas fa-trash"></i></div>
        <div class="modal-hapus-title">Hapus Data Pegawai?</div>
        <div class="modal-hapus-body">
            Yakin ingin menghapus data<br>
            <span class="modal-hapus-nama" id="modalNamaPegawai"></span>?
            <br><small style="font-size:11px;color:#9CA3AF;">Tindakan ini tidak dapat dibatalkan.</small>
        </div>
        <div class="modal-hapus-actions">
            <button class="btn-cancel-hapus" onclick="tutupModal()">Batal</button>
            <button class="btn-confirm-hapus" id="btnConfirmHapus">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    let formHapusId = null;
    function konfirmasiHapus(id, nama) {
        formHapusId = id;
        document.getElementById('modalNamaPegawai').textContent = nama;
        document.getElementById('modalHapus').classList.add('show');
    }
    function tutupModal() {
        document.getElementById('modalHapus').classList.remove('show');
        formHapusId = null;
    }
    document.getElementById('btnConfirmHapus').addEventListener('click', function () {
        if (formHapusId) document.getElementById('form-hapus-' + formHapusId).submit();
    });
    document.getElementById('modalHapus').addEventListener('click', function (e) {
        if (e.target === this) tutupModal();
    });

    const searchInput = document.getElementById('searchPegawai');
    if (searchInput && searchInput.value) {
        const len = searchInput.value.length;
        searchInput.setSelectionRange(len, len);
    }
</script>

@endsection
