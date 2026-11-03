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
                    <p class="text-muted small mb-0">Tambahkan data rombel baru ke sistem</p>
                </div>
                <div class="d-flex gap-2">
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
                <div class="card-body">
                    <p class="text-muted">Form untuk menambah rombel akan segera dilengkapi...</p>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
