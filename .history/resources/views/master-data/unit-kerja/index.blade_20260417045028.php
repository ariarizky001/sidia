@extends('layouts.admin')

@section('title', 'Master Data Unit Kerja')

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
                    <h4 class="fw-bold text-dark mb-0">Master Data Unit Kerja</h4>
                    <p class="text-muted small mb-0">Struktur hierarki unit kerja organisasi</p>
                </div>
                <a href="{{ route('unit-kerja.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Unit Kerja
                </a>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-12">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Card -->
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    @if($unitKerjas->count() > 0)
                        <div class="unit-tree">
                            @foreach($unitKerjas->where('level', 1)->whereNull('parent_id') as $level1)
                                <div class="tree-node mb-3">
                                    <!-- Level 1 -->
                                    <div class="tree-item level-1">
                                        <div class="item-header">
                                            <div class="item-content">
                                                <i class="fas fa-building text-primary"></i>
                                                <span class="item-name">{{ $level1->nama }}</span>
                                                <span class="item-level">Level 1</span>
                                                @if($level1->children->count() > 0)
                                                    <button class="btn btn-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#level2-{{ $level1->id }}" aria-expanded="true">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="item-actions">
                                                <a href="{{ route('unit-kerja.edit', $level1) }}" class="btn btn-xs btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('unit-kerja.destroy', $level1) }}" method="POST" class="d-inline"
                                                      onclick="return confirm('Yakin akan menghapus? Semua unit anak akan terhapus juga.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Level 2 -->
                                    @if($level1->children->count() > 0)
                                        <div class="collapse show" id="level2-{{ $level1->id }}">
                                            <div class="tree-children level-2-container">
                                                @foreach($level1->children->where('level', 2) as $level2)
                                                    <div class="tree-node mb-2">
                                                        <div class="tree-item level-2">
                                                            <div class="item-header">
                                                                <div class="item-content">
                                                                    <i class="fas fa-project-diagram text-info"></i>
                                                                    <span class="item-name">{{ $level2->nama }}</span>
                                                                    <span class="item-level">Level 2</span>
                                                                    @if($level2->children->count() > 0)
                                                                        <button class="btn btn-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#level3-{{ $level2->id }}" aria-expanded="true">
                                                                            <i class="fas fa-chevron-down"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                <div class="item-actions">
                                                                    <a href="{{ route('unit-kerja.edit', $level2) }}" class="btn btn-xs btn-warning" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('unit-kerja.destroy', $level2) }}" method="POST" class="d-inline"
                                                                          onclick="return confirm('Yakin akan menghapus? Semua unit anak akan terhapus juga.')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Level 3 -->
                                                        @if($level2->children->count() > 0)
                                                            <div class="collapse show" id="level3-{{ $level2->id }}">
                                                                <div class="tree-children level-3-container">
                                                            @foreach($level2->children->where('level', 3) as $level3)
                                                                <div class="tree-node mb-2">
                                                                    <div class="tree-item level-3">
                                                                        <div class="item-header">
                                                                            <div class="item-content">
                                                                                <i class="fas fa-sitemap text-success"></i>
                                                                                <span class="item-name">{{ $level3->nama }}</span>
                                                                                <span class="item-level">Level 3</span>
                                                                            </div>
                                                                            <div class="item-actions">
                                                                                <a href="{{ route('unit-kerja.edit', $level3) }}" class="btn btn-xs btn-warning" title="Edit">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                                <form action="{{ route('unit-kerja.destroy', $level3) }}" method="POST" class="d-inline"
                                                                                      onclick="return confirm('Yakin akan menghapus data ini?')">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                        </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-0">Belum ada data unit kerja</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <style>
        .unit-tree {
            font-size: 0.95rem;
        }

        .tree-node {
            position: relative;
        }

        .tree-item {
            padding: 12px 16px;
            border-radius: 4px;
            background: #f8f9fa;
            border-left: 3px solid #dee2e6;
            transition: all 0.2s ease;
        }

        .tree-item:hover {
            background: #e9ecef;
            border-left-color: #0066cc;
        }

        .tree-item.level-1 {
            border-left-color: #007bff;
            background: rgba(0, 123, 255, 0.05);
            margin-bottom: 8px;
        }

        .tree-item.level-1:hover {
            background: rgba(0, 123, 255, 0.1);
        }

        .tree-item.level-2 {
            border-left-color: #17a2b8;
            background: rgba(23, 162, 184, 0.03);
            margin-left: 24px;
        }

        .tree-item.level-2:hover {
            background: rgba(23, 162, 184, 0.08);
        }

        .tree-item.level-3 {
            border-left-color: #28a745;
            background: rgba(40, 167, 69, 0.03);
            margin-left: 48px;
        }

        .tree-item.level-3:hover {
            background: rgba(40, 167, 69, 0.08);
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .item-content {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .item-content i {
            font-size: 1rem;
            min-width: 20px;
            text-align: center;
        }

        .item-name {
            font-weight: 500;
            color: #333;
        }

        .item-level {
            font-size: 0.75rem;
            padding: 3px 8px;
            background: #fff;
            border-radius: 12px;
            color: #666;
            margin-left: 8px;
        }

        .tree-item.level-1 .item-level {
            background: #e3f2fd;
            color: #1976d2;
        }

        .tree-item.level-2 .item-level {
            background: #e0f2f1;
            color: #00796b;
        }

        .tree-item.level-3 .item-level {
            background: #e8f5e9;
            color: #388e3c;
        }

        .item-actions {
            display: flex;
            gap: 4px;
            margin-left: 12px;
        }

        .btn-xs {
            padding: 4px 8px;
            font-size: 0.75rem;
        }

        .tree-children {
            margin-top: 8px;
            padding-left: 0;
        }

        .level-2-container {
            border-left: 2px solid #dee2e6;
            padding-left: 12px;
            margin-left: 12px;
        }

        .level-3-container {
            border-left: 2px solid #dee2e6;
            padding-left: 12px;
            margin-left: 12px;
        }

        .btn-collapse {
            padding: 0;
            border: none;
            background: none;
            color: #666;
            font-size: 0.8rem;
            margin-left: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }

        .btn-collapse:hover {
            color: #007bff;
            transform: scale(1.1);
        }

        .btn-collapse[aria-expanded="false"] i {
            transform: rotate(-90deg);
        }

        .btn-collapse i {
            transition: transform 0.2s ease;
        }

        .collapse:not(.show) {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const level2Elements = document.querySelectorAll('[id^="level2-"]');

            level2Elements.forEach(level2 => {
                level2.addEventListener('hide.bs.collapse', function() {
                    // Ketika Level 2 akan ditutup, tutup semua Level 3 di dalamnya
                    const level3Elements = this.querySelectorAll('[id^="level3-"]');
                    level3Elements.forEach(level3 => {
                        level3.classList.remove('show');
                        // Update button state
                        const level3Button = level3.previousElementSibling.querySelector('.btn-collapse');
                        if (level3Button) {
                            level3Button.setAttribute('aria-expanded', 'false');
                        }
                    });
                });

                level2.addEventListener('show.bs.collapse', function() {
                    // Ketika Level 2 akan dibuka, buka kembali Level 3
                    const level3Elements = this.querySelectorAll('[id^="level3-"]');
                    level3Elements.forEach(level3 => {
                        level3.classList.add('show');
                        // Update button state
                        const level3Button = level3.previousElementSibling.querySelector('.btn-collapse');
                        if (level3Button) {
                            level3Button.setAttribute('aria-expanded', 'true');
                        }
                    });
                });
            });

            // Update button aria-expanded saat collapse berubah
            const allCollapseElements = document.querySelectorAll('.collapse');
            allCollapseElements.forEach(element => {
                element.addEventListener('show.bs.collapse', function() {
                    const button = document.querySelector(`button[data-bs-target="#${this.id}"]`);
                    if (button) button.setAttribute('aria-expanded', 'true');
                });

                element.addEventListener('hide.bs.collapse', function() {
                    const button = document.querySelector(`button[data-bs-target="#${this.id}"]`);
                    if (button) button.setAttribute('aria-expanded', 'false');
                });
            });
        });
    </script>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
