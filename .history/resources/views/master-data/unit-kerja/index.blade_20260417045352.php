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
            border-radius: 6px;
            background: #f8f9fa;
            border-left: 4px solid #dee2e6;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .tree-item:hover {
            background: #e9ecef;
            border-left-color: #0066cc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transform: translateX(2px);
        }

        .tree-item.level-1 {
            border-left-color: #007bff;
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.08) 0%, rgba(0, 123, 255, 0.02) 100%);
            margin-bottom: 12px;
        }

        .tree-item.level-1:hover {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.15) 0%, rgba(0, 123, 255, 0.08) 100%);
        }

        .tree-item.level-2 {
            border-left-color: #17a2b8;
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.06) 0%, rgba(23, 162, 184, 0.01) 100%);
            margin-left: 28px;
        }

        .tree-item.level-2:hover {
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.12) 0%, rgba(23, 162, 184, 0.06) 100%);
        }

        .tree-item.level-3 {
            border-left-color: #28a745;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.06) 0%, rgba(40, 167, 69, 0.01) 100%);
            margin-left: 56px;
        }

        .tree-item.level-3:hover {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.12) 0%, rgba(40, 167, 69, 0.06) 100%);
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
            margin-top: 12px;
            padding-left: 0;
            animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .level-2-container {
            border-left: 2px solid #e9ecef;
            padding-left: 16px;
            margin-left: 12px;
        }

        .level-3-container {
            border-left: 2px solid #e9ecef;
            padding-left: 16px;
            margin-left: 12px;
        }

        .btn-collapse {
            padding: 0;
            border: none;
            background: none;
            color: #666;
            font-size: 0.85rem;
            margin-left: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 4px;
        }

        .btn-collapse:hover {
            color: #007bff;
            background: rgba(0, 123, 255, 0.1);
            transform: scale(1.15);
        }

        .btn-collapse[aria-expanded="false"] i {
            transform: rotate(-90deg);
        }

        .btn-collapse i {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .collapse {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .collapsing {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hanya update button aria-expanded saat collapse toggle
            const buttons = document.querySelectorAll('.btn-collapse');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-bs-target').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        // Toggle akan handle Bootstrap, kita hanya update aria-expanded
                        setTimeout(() => {
                            const isOpen = targetElement.classList.contains('show');
                            this.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                        }, 10);
                    }
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
