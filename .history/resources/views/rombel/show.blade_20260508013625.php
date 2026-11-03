@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">{{ $title }}</h4>
                    <p class="text-muted small mb-0">Lihat detail rombel</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('rombel.edit', $rombel->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('rombel.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-layer-group"></i> {{ $rombel->nama_rombel }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Koordinator Wilayah Kecamatan</label>
                            <p class="fw-semibold">
                                <i class="fas fa-map-marker-alt text-info"></i>
                                {{ $rombel->unitKerjaParent?->nama ?? '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Sekolah Dasar</label>
                            <p class="fw-semibold">
                                <i class="fas fa-school text-primary"></i>
                                {{ $rombel->unitKerja?->nama ?? '-' }}
                            </p>
                        </div>
                    </div>

                    @if ($rombel->keterangan)
                        <div class="mb-3">
                            <label class="text-muted small">Keterangan</label>
                            <p class="card bg-light p-2 rounded">{{ $rombel->keterangan }}</p>
                        </div>
                    @endif

                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <label>Dibuat pada</label>
                            <p>{{ $rombel->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label>Diperbarui pada</label>
                            <p>{{ $rombel->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
