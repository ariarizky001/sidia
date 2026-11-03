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
                    <h4 class="fw-bold text-dark mb-0">Data Rombel</h4>
                    <p class="text-muted small mb-0">Kelola jumlah rombel berdasarkan kecamatan dan sekolah dasar</p>
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

            <!-- Purpose Card -->
            <div class="alert alert-light border mb-4" role="alert">
                <div class="row">
                    <div class="col-md-10">
                        <h5 class="alert-heading mb-2">
                            <i class="fas fa-book"></i> Tujuan Menu Rombel
                        </h5>
                        <p class="mb-0 small">
                            Menu ini digunakan untuk <strong>membuat dan mengelola data rombel</strong> (kelas) per sekolah dasar. 
                            Anda dapat <strong>menginput jumlah total rombel di setiap sekolah</strong> (contoh: SD 1 Colomadu memiliki 6 rombel), 
                            serta mengedit, melihat detail, dan menghapus data rombel.
                        </p>
                    </div>
                    <div class="col-md-2 text-end">
                        <small class="text-muted d-block">Fitur</small>
                        <strong><i class="fas fa-check-circle text-success"></i> Jumlah</strong>
                    </div>
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

            <!-- Filter Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('rombel.index') }}" class="row align-items-end">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small mb-2">
                                <i class="fas fa-filter"></i> Filter Koordinator Wilayah Kecamatan
                            </label>
                            <select name="kecamatan" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">-- Tampilkan Semua --</option>
                                @foreach ($unitKerjaLevel2 as $uk)
                                    <option value="{{ $uk->id }}" {{ $filterKecamatan == $uk->id ? 'selected' : '' }}>
                                        {{ $uk->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                @if ($filterKecamatan)
                                    <a href="{{ route('rombel.index') }}" class="btn btn-sm btn-secondary w-100">
                                        <i class="fas fa-times me-1"></i> Reset Filter
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Filter Info Badge -->
            @if ($filterKecamatan)
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Filter Aktif:</strong>
                    @php
                        $selectedKec = $unitKerjaLevel2->firstWhere('id', $filterKecamatan);
                    @endphp
                    {{ $selectedKec ? $selectedKec->nama : 'Tidak ditemukan' }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Summary Stats -->
            @if ($totalRombel > 0 || $statistik['total_sekolah'] > 0)
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2"><i class="fas fa-layer-group"></i> Total Rombel</h6>
                                <h3 class="fw-bold text-primary mb-0">{{ $totalRombel }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2"><i class="fas fa-map-marker-alt"></i> Total Kecamatan</h6>
                                <h3 class="fw-bold text-info mb-0">{{ $statistik['total_kecamatan'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2"><i class="fas fa-school"></i> Total Sekolah</h6>
                                <h3 class="fw-bold text-success mb-0">{{ $statistik['total_sekolah'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2"><i class="fas fa-calculator"></i> Rata-rata/Sekolah</h6>
                                <h3 class="fw-bold text-warning mb-0">{{ $statistik['total_sekolah'] > 0 ? round($totalRombel / $statistik['total_sekolah'], 1) : 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            @if (count($data) > 0)
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Koordinator Wilayah (Kecamatan)</th>
                                    <th>Sekolah Dasar</th>
                                    <th class="text-center">Jumlah Rombel</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $kecamatanId => $item)
                                    @php
                                        $sekolahList = $item['sekolah'];
                                        $sekolahCount = count($sekolahList);
                                        $schoolIndex = 0;
                                    @endphp
                                    @foreach ($sekolahList as $sekolahId => $sekolahData)
                                        @php $schoolIndex++; @endphp
                                        <tr>
                                            @if ($schoolIndex === 1)
                                                <td class="ps-4 fw-semibold align-middle" rowspan="{{ $sekolahCount }}">
                                                    <i class="fas fa-map-marker-alt text-info"></i> {{ $item['kecamatan']->nama }}
                                                </td>
                                            @endif
                                            <td>
                                                <i class="fas fa-school text-primary"></i> {{ $sekolahData['sekolah']->nama }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary" title="Total jumlah rombel di sekolah ini">
                                                    {{ $sekolahData['jumlah_rombel'] }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @if ($sekolahData['rombel_id'])
                                                        <a href="{{ route('rombel.show', $sekolahData['rombel_id']) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('rombel.edit', $sekolahData['rombel_id']) }}" class="btn btn-outline-warning" title="Edit Jumlah">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form method="POST" action="{{ route('rombel.destroy', $sekolahData['rombel_id']) }}" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Hapus Data"
                                                                    onclick="return confirm('Yakin akan menghapus data rombel sekolah ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-outline-secondary" disabled title="Belum ada data">
                                                            <i class="fas fa-ban"></i> Tidak ada
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-0">
                            @if ($filterKecamatan)
                                Belum ada data rombel untuk koordinator wilayah yang dipilih
                            @else
                                Belum ada data rombel
                            @endif
                        </p>
                        <a href="{{ route('rombel.create') }}" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-plus me-1"></i> Tambah Rombel Pertama
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
