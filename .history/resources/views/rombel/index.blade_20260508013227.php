@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .kecamatan-header { background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%); color: white; padding: 1rem; border-radius: 8px; margin-top: 1.5rem; margin-bottom: 1rem; }
    .kecamatan-header i { margin-right: 0.5rem; }
    .sekolah-section { background: #f8f9fa; border-left: 4px solid #0dcaf0; padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
    .sekolah-title { font-weight: 600; color: #0c5aa8; margin-bottom: 0.75rem; }
    .rombel-item { background: white; padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 4px; border-left: 3px solid #28a745; }
    .rombel-item:hover { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .empty-state-section { background: white; padding: 2rem; border-radius: 8px; text-align: center; color: #6c757d; margin: 2rem 0; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Data Rombel</h4>
                    <p class="text-muted small mb-0">Kelola data rombel berdasarkan unit kerja dan sekolah</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('rombel.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Rombel
                    </a>
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

            <!-- Summary Card -->
            @if ($totalRombel > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2"><i class="fas fa-layer-group"></i> Total Rombel</h6>
                                <h3 class="fw-bold text-primary">{{ $totalRombel }}</h3>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2"><i class="fas fa-school"></i> Koordinator Wilayah</h6>
                                <h3 class="fw-bold text-info">{{ count($data) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Data by Unit Kerja Structure -->
            @if (count($data) > 0)
                @foreach ($data as $kecamatanId => $item)
                    <div class="kecamatan-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <strong>{{ $item['kecamatan']->nama }}</strong>
                        <span class="badge bg-light text-dark float-end">
                            {{ collect($item['sekolah'])->sum(fn($s) => $s['rombel']->count()) }} Rombel
                        </span>
                    </div>

                    @if (count($item['sekolah']) > 0)
                        @foreach ($item['sekolah'] as $sekolahId => $sekolahData)
                            <div class="sekolah-section">
                                <div class="sekolah-title">
                                    <i class="fas fa-school"></i> {{ $sekolahData['sekolah']->nama }}
                                </div>

                                @if ($sekolahData['rombel']->count() > 0)
                                    @foreach ($sekolahData['rombel'] as $rombel)
                                        <div class="rombel-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $rombel->nama_rombel }}</strong>
                                                    @if ($rombel->keterangan)
                                                        <div class="small text-muted">{{ $rombel->keterangan }}</div>
                                                    @endif
                                                </div>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('rombel.show', $rombel->id) }}" class="btn btn-outline-primary" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('rombel.edit', $rombel->id) }}" class="btn btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('rombel.destroy', $rombel->id) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Hapus"
                                                                onclick="return confirm('Yakin akan menghapus data ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted small">
                                        <i class="fas fa-inbox"></i> Belum ada rombel di sekolah ini
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state-section">
                            <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-2">Belum ada sekolah (Unit Kerja Level 3) di wilayah ini</p>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada koordinator wilayah (Unit Kerja Level 2)</p>
                        <a href="{{ route('rombel.create') }}" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-plus me-1"></i> Tambah Rombel Pertama
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

</div>

@endsection
