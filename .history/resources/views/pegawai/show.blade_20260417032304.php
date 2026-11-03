@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .detail-container { max-width: 900px; margin: 0 auto; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Detail Pegawai / ASN</h4>
                    <p class="text-muted small mb-0">{{ $pegawai->nip }} • {{ $pegawai->nama_lengkap }}</p>
                </div>
                <div>
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-container py-3">
        <div class="row">
            <div class="col-lg-12">

            <!-- Section A: Identitas Pegawai -->
            <div class="form-card mb-4">
                <h2 class="section-title mb-4">A. IDENTITAS PEGAWAI</h2>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">NIP</label>
                        <p class="fw-bold text-primary">{{ $pegawai->nip }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Status ASN</label>
                        <p class="fw-bold">
                            <span class="badge bg-info">{{ $pegawai->status_asn }}</span>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <p class="fw-bold text-dark">{{ $pegawai->nama_lengkap }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Tanggal Lahir</label>
                        <p class="fw-bold text-dark">
                            {{ $pegawai->tgl_lahir?->format('d F Y') ?? '-' }}
                            <small class="text-muted">({{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->age }} tahun)</small>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section B: Pensiun & Status Aktif -->
            <div class="form-card mb-4">
                <h2 class="section-title mb-4">B. PENSIUN & STATUS AKTIF</h2>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">BUP (tahun)</label>
                        <p class="fw-bold text-dark">{{ $pegawai->bup ?? '-' }} tahun</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">Tanggal Pensiun</label>
                        <p class="fw-bold text-dark">{{ $pegawai->pensiun?->format('d F Y') ?? ' -' }}</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">Status Aktif</label>
                        <p class="fw-bold">
                            @if ($pegawai->status_aktif === 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">Sisa Masa Kerja</label>
                        <p class="fw-bold text-dark">
                            @if ($pegawai->tgl_lahir && $pegawai->bup)
                                @php
                                    $tgl_pensiun = \Carbon\Carbon::parse($pegawai->tgl_lahir)->addYears($pegawai->bup);
                                    $sisa = $tgl_pensiun->diffInYears(\Carbon\Carbon::now());
                                @endphp
                                {{ max(0, $sisa) }} tahun
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section C: Kepangkatan & Golongan -->
            <div class="form-card mb-4">
                <h2 class="section-title mb-4">C. KEPANGKATAN & GOLONGAN</h2>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Golongan / Ruang</label>
                        <p class="fw-bold text-dark text-uppercase">{{ $pegawai->golongan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">TMT Golongan</label>
                        <p class="fw-bold text-dark">{{ $pegawai->tmt_golongan?->format('d F Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Section D: Jabatan -->
            <div class="form-card mb-4">
                <h2 class="section-title mb-4">D. JABATAN</h2>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Jabatan</label>
                        <p class="fw-bold text-dark">{{ $pegawai->jabatan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">TMT Jabatan</label>
                        <p class="fw-bold text-dark">{{ $pegawai->tmt_jabatan?->format('d F Y') ?? '-' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted">Formasi Jabatan</label>
                        <p class="fw-bold text-dark">{{ $pegawai->formasi_jabatan ?? 'Belum ada formasi' }}</p>
                    </div>
                </div>
            </div>

            <!-- Section E: Pendidikan -->
            <div class="form-card mb-4">
                <h2 class="section-title mb-4">E. PENDIDIKAN</h2>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Jenjang Pendidikan</label>
                        <p class="fw-bold text-dark">
                            @switch($pegawai->pendidikan)
                                @case('S3')
                                    S3 / Doktoral
                                    @break
                                @case('S2')
                                    S2 / Magister
                                    @break
                                @case('S1')
                                    S1 / Sarjana
                                    @break
                                @case('D3')
                                    D3 / Diploma
                                    @break
                                @case('SMA')
                                    SMA / SMK
                                    @break
                                @case('SMP')
                                    SMP
                                    @break
                                @case('SD')
                                    SD
                                    @break
                                @default
                                    -
                            @endswitch
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Tahun Lulus</label>
                        <p class="fw-bold text-dark">{{ $pegawai->thn_lulus ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Section F: Unit Kerja -->
            <div class="form-card mb-4">
                <h2 class="section-title mb-4">F. PENEMPATAN / UNIT KERJA</h2>

                <div class="card border-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small">Unit Kerja 1</label>
                                <p class="fw-bold text-dark">{{ $pegawai->unit_kerja_satu ?? '-' }}</p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small">Unit Kerja 2</label>
                                <p class="fw-bold text-dark">{{ $pegawai->unit_kerja_2 ?? '-' }}</p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small">Unit Kerja 3</label>
                                <p class="fw-bold text-dark">{{ $pegawai->unit_kerja_3 ?? '-' }}</p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small">Unit Kerja 4</label>
                                <p class="fw-bold text-dark">{{ $pegawai->unit_kerja_4 ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="form-actions mb-5">
                <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-edit me-2"></i> Edit Data
                </a>
            </div>

            </div>
        </div>
    </div>
</div>

@endsection
