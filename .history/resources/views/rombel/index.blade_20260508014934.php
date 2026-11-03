@extends('layouts.admin')

@section('content')

<style>
    .page-header { position: sticky; top: 0; background: white; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.08); padding: 1rem 0; margin-bottom: 1.5rem; }
    .section-header { background: #f8f9fa; padding: 0.75rem 1rem; border-bottom: 2px solid #0d6efd; font-weight: 600; color: #0c5aa8; margin-top: 1.5rem; margin-bottom: 0; border-radius: 4px 4px 0 0; }
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

            <!-- Purpose Card -->
            <div class="alert alert-light border mb-4" role="alert">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="alert-heading mb-2">
                            <i class="fas fa-book"></i> Tujuan Menu Rombel
                        </h5>
                        <p class="mb-0 small">
                            Menu ini digunakan untuk <strong>membuat dan mengelola data rombel</strong> (kelas) per sekolah dasar.
                            Anda dapat melihat <strong>jumlah rombel per unit kerja</strong> (kecamatan dan sekolah),
                            menambah rombel baru, mengedit, melihat detail, dan menghapus data rombel yang sudah ada.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="row text-center">
                            <div class="col-6">
                                <small class="text-muted d-block">CRUD</small>
                                <strong><i class="fas fa-check-circle text-success"></i> Lengkap</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Filter</small>
                                <strong><i class="fas fa-filter text-info"></i> Aktif</strong>
                            </div>
                        </div>
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
            @if ($totalRombel > 0)
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

            <!-- Statistik Rombel Per Unit Kerja -->
            @if (count($statistik['rombel_per_kecamatan']) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Statistik Rombel Per Koordinator Wilayah</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Koordinator Wilayah Kecamatan</th>
                                    <th class="text-center">Total Sekolah</th>
                                    <th class="text-center">Total Rombel</th>
                                    <th class="text-center pe-4">Rata-rata/Sekolah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statistik['rombel_per_kecamatan'] as $stat)
                                    <tr>
                                        <td class="ps-4">
                                            <i class="fas fa-map-marker-alt text-info"></i> {{ $stat['kecamatan_nama'] }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $stat['total_sekolah'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $stat['total_rombel'] }}</span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <span class="badge bg-warning">{{ $stat['total_sekolah'] > 0 ? round($stat['total_rombel'] / $stat['total_sekolah'], 1) : 0 }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                    <th class="ps-4">Koordinator Wilayah</th>
                                    <th>Sekolah Dasar</th>
                                    <th>Nama Rombel</th>
                                    <th>Keterangan</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $kecamatanId => $item)
                                    @foreach ($item['sekolah'] as $sekolahId => $sekolahData)
                                        @if ($sekolahData['rombel']->count() > 0)
                                            @foreach ($sekolahData['rombel'] as $index => $rombel)
                                                <tr>
                                                    @if ($index === 0)
                                                        <td class="ps-4 fw-semibold align-middle" rowspan="{{ $sekolahData['rombel']->count() }}">
                                                            <i class="fas fa-map-marker-alt text-info"></i> {{ $item['kecamatan']->nama }}
                                                        </td>
                                                        <td class="align-middle" rowspan="{{ $sekolahData['rombel']->count() }}">
                                                            <i class="fas fa-school text-primary"></i> {{ $sekolahData['sekolah']->nama }}
                                                        </td>
                                                    @endif
                                                    <td class="ps-4">
                                                        <span class="badge bg-light text-dark">{{ $rombel->nama_rombel }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($rombel->keterangan)
                                                            <small class="text-muted">{{ Str::limit($rombel->keterangan, 50) }}</small>
                                                        @else
                                                            <small class="text-muted">-</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-end pe-4">
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
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="ps-4 fw-semibold">{{ $item['kecamatan']->nama }}</td>
                                                <td><i class="fas fa-school"></i> {{ $sekolahData['sekolah']->nama }}</td>
                                                <td colspan="3" class="text-muted text-center">
                                                    <small><i class="fas fa-inbox"></i> Belum ada rombel</small>
                                                </td>
                                            </tr>
                                        @endif
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
                                Belum ada koordinator wilayah (Unit Kerja Level 2)
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
