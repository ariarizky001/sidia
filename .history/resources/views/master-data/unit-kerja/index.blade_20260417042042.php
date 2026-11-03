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
                    <h3 class="card-title">Daftar Unit Kerja (Struktur Hierarki)</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Tampilkan Level 1 Units --}}
                    <div class="unit-kerja-tree">
                        @forelse($unitKerjas->where('level', 1)->where('parent_id', null) as $level1)
                            <div class="level-1 mb-3">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-sitemap"></i>
                                            <strong>{{ $level1->nama }}</strong>
                                            <span class="badge badge-light">Level 1</span>
                                        </span>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('unit-kerja.edit', $level1) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('unit-kerja.destroy', $level1) }}" method="POST" class="d-inline" onclick="return confirm('Yakin akan menghapus unit kerja ini? Data unit kerja anak juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {{-- Tampilkan Level 2 Units --}}
                                        @if($level1->children->count() > 0)
                                            <div class="ml-4">
                                                @foreach($level1->children->where('level', 2) as $level2)
                                                    <div class="level-2 mb-2">
                                                        <div class="card border-info">
                                                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center py-2">
                                                                <span>
                                                                    <i class="fas fa-code-branch"></i>
                                                                    {{ $level2->nama }}
                                                                    <span class="badge badge-light">Level 2</span>
                                                                </span>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('unit-kerja.edit', $level2) }}" class="btn btn-warning">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('unit-kerja.destroy', $level2) }}" method="POST" class="d-inline" onclick="return confirm('Yakin akan menghapus unit kerja ini? Data unit kerja anak juga akan terhapus.')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                {{-- Tampilkan Level 3 Units --}}
                                                                @if($level2->children->count() > 0)
                                                                    <div class="ml-4">
                                                                        @foreach($level2->children->where('level', 3) as $level3)
                                                                            <div class="level-3 mb-2">
                                                                                <div class="card border-success">
                                                                                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2">
                                                                                        <span>
                                                                                            <i class="fas fa-leaf"></i>
                                                                                            {{ $level3->nama }}
                                                                                            <span class="badge badge-light">Level 3</span>
                                                                                        </span>
                                                                                        <div class="btn-group btn-group-sm">
                                                                                            <a href="{{ route('unit-kerja.edit', $level3) }}" class="btn btn-warning">
                                                                                                <i class="fas fa-edit"></i>
                                                                                            </a>
                                                                                            <form action="{{ route('unit-kerja.destroy', $level3) }}" method="POST" class="d-inline" onclick="return confirm('Yakin akan menghapus unit kerja ini?')">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button type="submit" class="btn btn-danger">
                                                                                                    <i class="fas fa-trash"></i>
                                                                                                </button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <small class="text-muted"><i class="fas fa-info-circle"></i> Tidak ada data Level 3</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <small class="text-muted"><i class="fas fa-info-circle"></i> Tidak ada data Level 2</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-info-circle"></i> Belum ada data unit kerja
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .unit-kerja-tree .level-1 .card-header {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .unit-kerja-tree .level-2 .card-header {
            font-size: 1rem;
        }

        .unit-kerja-tree .level-3 .card-header {
            font-size: 0.95rem;
        }

        .unit-kerja-tree .card-body {
            padding: 1rem;
        }

        .unit-kerja-tree .card {
            border-width: 2px;
        }
    </style>
@endsection
