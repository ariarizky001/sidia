@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-graduation-cap mr-2"></i>Daftar Sekolah Menengah Pertama
                </h3>
                <div class="card-tools">
                    <span class="badge badge-success badge-lg">
                        Total: {{ $sekolah->total() }} SMP
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Filter Section --}}
                <form method="GET" action="{{ route('data-smp.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Cari nama sekolah..."
                                       value="{{ $search }}">
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <select name="kelompok_id" class="form-control">
                                <option value="">-- Semua Kelompok SMP --</option>
                                @foreach($kelompokSMP as $kelompok)
                                    <option value="{{ $kelompok->id }}" 
                                            {{ $selectedKelompok == $kelompok->id ? 'selected' : '' }}>
                                        {{ $kelompok->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Tabel Sekolah --}}
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">Nama Sekolah</th>
                                <th width="25%">Kelompok</th>
                                <th width="15%" class="text-center">Jumlah Pegawai</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sekolah as $index => $smp)
                                <tr>
                                    <td>{{ $sekolah->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $smp->nama }}</strong>
                                    </td>
                                    <td>
                                        @if($smp->parent)
                                            <small class="text-muted">
                                                {{ $smp->parent->nama }}
                                            </small>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            {{ \App\Models\Pegawai::where('unit_kerja_3_id', $smp->id)->count() }} Pegawai
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('data-smp.show', $smp->id) }}" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data sekolah ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $sekolah->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
