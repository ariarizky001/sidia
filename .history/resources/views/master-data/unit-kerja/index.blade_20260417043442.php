@extends('layouts.admin')

@section('title', 'Master Data Unit Kerja')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Master Data Unit Kerja</h1>
        </div>
        <div class="col-sm-6">
            <a href="{{ route('unit-kerja.create') }}" class="btn btn-primary float-right">
                <i class="fas fa-plus"></i> Tambah Unit Kerja
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Unit Kerja</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($unitKerjas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Nama Unit Kerja</th>
                                        <th style="width: 12%">Level</th>
                                        <th style="width: 20%">Parent Unit</th>
                                        <th style="width: 20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unitKerjas as $key => $unit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $unit->nama }}</strong>
                                            </td>
                                            <td>
                                                @if($unit->level == 1)
                                                    <span class="badge badge-primary">Level 1 - Induk</span>
                                                @elseif($unit->level == 2)
                                                    <span class="badge badge-info">Level 2 - Korwil/Bidang</span>
                                                @elseif($unit->level == 3)
                                                    <span class="badge badge-success">Level 3 - Sekolah/Seksi</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($unit->parent)
                                                    <small>{{ $unit->parent->nama }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('unit-kerja.edit', $unit) }}" class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('unit-kerja.destroy', $unit) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Hapus"
                                                                onclick="return confirm('Yakin akan menghapus data ini? Semua unit anak akan terhapus juga.')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center py-5">
                            <i class="fas fa-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-3">Belum ada data unit kerja</p>
                            <a href="{{ route('unit-kerja.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus"></i> Tambah Unit Kerja Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
