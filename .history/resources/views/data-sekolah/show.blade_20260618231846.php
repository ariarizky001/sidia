@extends('layouts.admin')

@section('content')

<style>
    .page-header { 
        position: sticky; 
        top: 0; 
        background: white; 
        z-index: 100; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.08); 
        padding: 1rem 0; 
        margin-bottom: 1.5rem; 
    }
    
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('data-sekolah.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <h4 class="fw-bold text-dark mb-0">
                        <i class="fas fa-school me-2"></i>{{ $sekolah->nama }}
                    </h4>
                    <p class="text-muted small mb-0">Data Pegawai di Sekolah (Semua Status)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-12">
            <!-- Alert Messages -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Stats Card -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-muted small mb-2">Total Pegawai</h5>
                            <h3 class="text-primary fw-bold">{{ $pegawai->total() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-muted small mb-2">Pegawai Aktif</h5>
                            <h3 class="text-success fw-bold">{{ $pegawai->getCollection()->where('status_aktif', 'aktif')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-muted small mb-2">Status PNS</h5>
                            <h3 class="text-info fw-bold">{{ $pegawai->getCollection()->where('status_asn_id', 1)->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-muted small mb-2">Status PPPK</h5>
                            <h3 class="text-warning fw-bold">{{ $pegawai->getCollection()->where('status_asn_id', 2)->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-muted small mb-2">Status PPPK-PW</h5>
                            <h3 class="text-secondary fw-bold">{{ $pegawai->getCollection()->where('status_asn_id', 3)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            @if ($pegawai->count() > 0)
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">NIP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Status ASN</th>
                                    <th>Golongan</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pegawai as $item)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">{{ $item->nip }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->nama_lengkap }}</div>
                                            <small class="text-muted">{{ $item->tgl_lahir?->format('d M Y') ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $statusColor = match($item->status_asn_id) {
                                                    1 => 'bg-info',
                                                    2 => 'bg-warning',
                                                    3 => 'bg-secondary',
                                                    default => 'bg-light'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusColor }}">{{ $item->statusAsnData?->nama ?? '-' }}</span>
                                        </td>
                                        <td>{{ $item->golonganData?->kode ?? '-' }}</td>
                                        <td>{{ $item->jabatanData?->nama_jabatan ?? '-' }}</td>
                                        <td>
                                            <small class="text-muted">
                                                @if ($item->unit_kerja_1_id == $sekolah->id)
                                                    <span class="status-badge bg-light text-dark border">UK1</span>
                                                @endif
                                                @if ($item->unit_kerja_2_id == $sekolah->id)
                                                    <span class="status-badge bg-light text-dark border">UK2</span>
                                                @endif
                                                @if ($item->unit_kerja_3_id == $sekolah->id)
                                                    <span class="status-badge bg-light text-dark border">UK3</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('pegawai.show', $item->id) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Menampilkan <strong>{{ $pegawai->firstItem() }}</strong> sampai <strong>{{ $pegawai->lastItem() }}</strong> dari <strong>{{ $pegawai->total() }}</strong> data pegawai
                    </div>
                    <nav aria-label="Page navigation">
                        {{ $pegawai->links('pagination::bootstrap-4') }}
                    </nav>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada pegawai yang terdata di sekolah ini</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
