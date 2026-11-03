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
    
    .sekolah-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-left: 4px solid transparent;
    }
    
    .sekolah-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-left-color: #007bff;
    }
    
    .sekolah-card-body {
        padding: 1.5rem;
    }
    
    .sekolah-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    
    .sekolah-info {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .sekolah-info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .sekolah-info-item i {
        color: #007bff;
        width: 20px;
        text-align: center;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Data Sekolah</h4>
                    <p class="text-muted small mb-0">Lihat data sekolah dan pegawai yang terdata di setiap sekolah</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-12">
            <!-- Filter Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('data-sekolah.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="unit_kerja_2_id" class="form-label">
                                <i class="fas fa-filter me-2"></i>Filter by Unit Kerja 2
                            </label>
                            <select name="unit_kerja_2_id" id="unit_kerja_2_id" class="form-select">
                                <option value="">-- Semua Unit Kerja --</option>
                                @foreach ($unitKerja2 as $uk)
                                    <option value="{{ $uk->id }}" {{ $selectedUK2 == $uk->id ? 'selected' : '' }}>
                                        {{ $uk->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Terapkan Filter
                            </button>
                            @if($selectedUK2)
                                <a href="{{ route('data-sekolah.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-redo me-1"></i>Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

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

            <!-- Sekolah List -->
            @if ($sekolah->count() > 0)
                <div class="row">
                    @foreach ($sekolah as $item)
                        @php
                            $countPegawai = \App\Models\Pegawai::where(function($q) use ($item) {
                                $q->where('unit_kerja_1_id', $item->id)
                                  ->orWhere('unit_kerja_2_id', $item->id)
                                  ->orWhere('unit_kerja_3_id', $item->id);
                            })->count();
                        @endphp
                        <div class="col-md-6 col-lg-4 mb-4">
                            <a href="{{ route('data-sekolah.show', $item->id) }}" class="text-decoration-none">
                                <div class="card sekolah-card h-100">
                                    <div class="sekolah-card-body">
                                        <i class="fas fa-school text-primary mb-2" style="font-size: 1.5rem;"></i>
                                        <div class="sekolah-name">{{ $item->nama }}</div>
                                        
                                        <div class="sekolah-info">
                                            <div class="sekolah-info-item">
                                                <i class="fas fa-users"></i>
                                                <span>{{ $countPegawai }} Pegawai</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3 pt-2 border-top">
                                            <small class="text-muted">
                                                <i class="fas fa-arrow-right me-1"></i>Klik untuk melihat detail
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($sekolah->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sekolah->links() }}
                    </div>
                @endif
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Informasi:</strong> Belum ada data sekolah. Tambahkan sekolah melalui menu Master Data > Unit Kerja.
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
