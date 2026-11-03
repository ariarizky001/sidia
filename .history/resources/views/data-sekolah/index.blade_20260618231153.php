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
                        <div class="col-md-6 col-lg-4 mb-4">
                            <a href="{{ route('data-sekolah.show', $item->id) }}" class="text-decoration-none">
                                <div class="card sekolah-card h-100">
                                    <div class="sekolah-card-body">
                                        <i class="fas fa-school text-primary mb-2" style="font-size: 1.5rem;"></i>
                                        <div class="sekolah-name">{{ $item->nama }}</div>
                                        
                                        <div class="sekolah-info">
                                            <div class="sekolah-info-item">
                                                <i class="fas fa-users"></i>
                                                <span>{{ $item->pegawais()->count() }} Pegawai</span>
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
