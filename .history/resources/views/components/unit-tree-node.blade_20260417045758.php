@props(['unit', 'level' => 1])

<div class="tree-node mb-2">
    <div class="tree-item level-{{ $level }}">
        <div class="item-header">
            <div class="item-content">
                @if($level == 1)
                    <i class="fas fa-building"></i>
                @elseif($level == 2)
                    <i class="fas fa-sitemap"></i>
                @else
                    <i class="fas fa-folder"></i>
                @endif
                <span class="item-name">{{ $unit->nama }}</span>
                <span class="item-level">Level {{ $unit->level }}</span>
                @if($unit->children->count() > 0)
                    <button class="btn btn-collapse" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#level-{{ $unit->id }}" aria-expanded="true">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                @endif
            </div>
            <div class="item-actions">
                <a href="{{ route('unit-kerja.edit', $unit) }}" class="btn btn-xs btn-warning" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('unit-kerja.destroy', $unit) }}" method="POST" class="d-inline"
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

    @if($unit->children->count() > 0)
        <div class="collapse show" id="level-{{ $unit->id }}">
            <div class="tree-children level-{{ $level + 1 }}-container">
                @foreach($unit->children->sortBy('nama') as $child)
                    <x-unit-tree-node :unit="$child" :level="$level + 1" />
                @endforeach
            </div>
        </div>
    @endif
</div>
