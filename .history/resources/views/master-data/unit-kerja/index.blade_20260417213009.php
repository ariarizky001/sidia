@extends('layouts.admin')

@section('title', 'Master Data Unit Kerja')

@section('content')

<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="text-dark fw-bold mb-1">Master Data Unit Kerja</h3>
            <p class="text-muted mb-0">Kelola struktur hierarki unit kerja organisasi</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('unit-kerja.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Unit Kerja
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            @if($unitKerjas->count() > 0)
                <!-- Action Buttons -->
                <div class="mb-3">
                    <button class="btn btn-sm btn-outline-primary" id="expandAll">
                        <i class="fas fa-plus-circle me-1"></i> Buka Semua
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" id="collapseAll">
                        <i class="fas fa-minus-circle me-1"></i> Tutup Semua
                    </button>
                </div>

                <!-- Unit Tree -->
                <div class="unit-tree">
                    @foreach($unitKerjas->where('level', 1)->whereNull('parent_id')->sortBy('nama') as $root)
                        <x-unit-tree-node :unit="$root" :level="1" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-building text-secondary" style="font-size: 4rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada data unit kerja</p>
                </div>
            @endif

        </div>
    </div>

</div>

<style>
    /* Tree Styling */
    .unit-tree {
        font-size: 0.95rem;
    }

    .tree-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        margin-bottom: 8px;
        background: #f8f9fa;
        border-left: 3px solid #dee2e6;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .tree-item:hover {
        background: #e9ecef;
        transform: translateX(2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    }

    /* Level Colors */
    .tree-item.level-1 {
        border-left-color: #007bff;
        background: #f0f7ff;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .tree-item.level-1:hover {
        background: #e3f2fd;
    }

    .tree-item.level-2 {
        border-left-color: #17a2b8;
        background: #f0f7f7;
        margin-left: 24px;
    }

    .tree-item.level-2:hover {
        background: #e0f7f7;
    }

    .tree-item.level-3 {
        border-left-color: #28a745;
        background: #f7f7f0;
        margin-left: 48px;
    }

    .tree-item.level-3:hover {
        background: #f0f7f0;
    }

    .tree-item.level-4,
    .tree-item.level-5,
    .tree-item.level-6 {
        border-left-color: #ffc107;
        background: #fffbf0;
        margin-left: 72px;
    }

    .tree-item.level-4:hover,
    .tree-item.level-5:hover,
    .tree-item.level-6:hover {
        background: #fff9e6;
    }

    /* Item Header */
    .item-header {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }

    .item-content {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }

    .item-icon {
        width: 24px;
        text-align: center;
        color: #666;
    }

    .item-name {
        font-weight: 500;
        color: #333;
        word-break: break-word;
    }

    .item-level-badge {
        font-size: 0.75rem;
        padding: 3px 10px;
        background: #e9ecef;
        color: #666;
        border-radius: 12px;
        margin-left: auto;
        margin-right: 10px;
        white-space: nowrap;
    }

    .tree-item.level-1 .item-level-badge {
        background: #cfe2ff;
        color: #084298;
    }

    .tree-item.level-2 .item-level-badge {
        background: #cffafe;
        color: #155e75;
    }

    .tree-item.level-3 .item-level-badge {
        background: #dcfce7;
        color: #166534;
    }

    .tree-item.level-4 .item-level-badge,
    .tree-item.level-5 .item-level-badge,
    .tree-item.level-6 .item-level-badge {
        background: #fef08a;
        color: #854d0e;
    }

    /* Action Buttons */
    .item-actions {
        display: flex;
        gap: 6px;
    }

    .btn-action {
        padding: 4px 10px;
        font-size: 0.85rem;
        border: 1px solid #dee2e6;
        background: white;
        color: #666;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }

    .btn-action.edit {
        color: #0066cc;
    }

    .btn-action.edit:hover {
        background: #0066cc;
        color: white;
    }

    .btn-action.delete {
        color: #dc3545;
    }

    .btn-action.delete:hover {
        background: #dc3545;
        color: white;
    }

    /* Collapse/Toggle */
    .toggle-btn {
        padding: 0;
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        font-size: 0.9rem;
        width: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toggle-btn:hover {
        color: #007bff;
    }

    .tree-children {
        margin-top: 8px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            max-height: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            max-height: 9999px;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tree-item {
            flex-wrap: wrap;
            gap: 8px;
        }

        .item-level-badge {
            margin-left: 0;
            margin-right: 0;
            order: 3;
            flex-basis: 100%;
        }

        .item-actions {
            order: 4;
            width: 100%;
            justify-content: flex-start;
        }

        .tree-item.level-2 {
            margin-left: 16px;
        }

        .tree-item.level-3 {
            margin-left: 32px;
        }

        .tree-item.level-4,
        .tree-item.level-5,
        .tree-item.level-6 {
            margin-left: 48px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Expand All
    document.getElementById('expandAll')?.addEventListener('click', function() {
        document.querySelectorAll('.tree-children').forEach(el => {
            el.style.display = 'block';
            el.parentElement?.querySelector('.toggle-btn')?.classList.remove('collapsed');
        });
    });

    // Collapse All
    document.getElementById('collapseAll')?.addEventListener('click', function() {
        document.querySelectorAll('.tree-children').forEach(el => {
            el.style.display = 'none';
            el.parentElement?.querySelector('.toggle-btn')?.classList.add('collapsed');
        });
    });

    // Toggle Individual Items
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const container = this.closest('.tree-node')?.querySelector('.tree-children');
            if (container) {
                const isHidden = container.style.display === 'none';
                container.style.display = isHidden ? 'block' : 'none';
                this.classList.toggle('collapsed');
            }
        });
    });
});
</script>

@endsection
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .tree-item {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            .item-header {
                flex-wrap: wrap;
                gap: 8px;
            }

            .item-actions {
                margin-left: 0;
                order: 3;
                flex-basis: 100%;
                margin-top: 8px;
            }

            .tree-item.level-2 {
                margin-left: 16px;
            }

            .tree-item.level-3 {
                margin-left: 32px;
            }

            .tree-item.level-4,
            .tree-item.level-5,
            .tree-item.level-6 {
                margin-left: 48px;
            }

            .item-name {
                font-size: 0.9rem;
            }

            .item-level {
                font-size: 0.7rem;
                padding: 2px 6px;
            }
        }

        @media (max-width: 480px) {
            .item-content {
                gap: 6px;
            }

            .item-content i {
                font-size: 0.9rem;
            }

            .tree-item.level-2 {
                margin-left: 12px;
            }

            .tree-item.level-3 {
                margin-left: 24px;
            }

            .tree-item.level-4,
            .tree-item.level-5,
            .tree-item.level-6 {
                margin-left: 36px;
            }

            .btn-xs {
                padding: 3px 6px;
                font-size: 0.7rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-collapse');
            const expandAllBtn = document.getElementById('expandAll');
            const collapseAllBtn = document.getElementById('collapseAll');

            // Update button aria-expanded saat collapse toggle
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-bs-target').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        setTimeout(() => {
                            const isOpen = targetElement.classList.contains('show');
                            this.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                        }, 10);
                    }
                });
            });

            // Expand all functionality
            if (expandAllBtn) {
                expandAllBtn.addEventListener('click', function() {
                    buttons.forEach(btn => {
                        const targetId = btn.getAttribute('data-bs-target').substring(1);
                        const collapseEl = document.getElementById(targetId);
                        if (collapseEl && !collapseEl.classList.contains('show')) {
                            const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });
                            bsCollapse.show();
                            btn.setAttribute('aria-expanded', 'true');
                        }
                    });
                });
            }

            // Collapse all functionality
            if (collapseAllBtn) {
                collapseAllBtn.addEventListener('click', function() {
                    buttons.forEach(btn => {
                        const targetId = btn.getAttribute('data-bs-target').substring(1);
                        const collapseEl = document.getElementById(targetId);
                        if (collapseEl && collapseEl.classList.contains('show')) {
                            const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });
                            bsCollapse.hide();
                            btn.setAttribute('aria-expanded', 'false');
                        }
                    });
                });
            }

            // Auto-collapse level 3+ pada load
            buttons.forEach(btn => {
                const targetId = btn.getAttribute('data-bs-target');
                const collapseEl = document.querySelector(targetId);

                if (collapseEl && btn.closest('.tree-item').classList.contains('level-3')) {
                    const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });
                    bsCollapse.hide();
                    btn.setAttribute('aria-expanded', 'false');
                }
            });

            // Keyboard support - Enter/Space to toggle
            buttons.forEach(btn => {
                btn.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        btn.click();
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
