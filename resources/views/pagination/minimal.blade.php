@if ($paginator->hasPages())
<nav aria-label="Page navigation">
    <ul class="pagination-minimal">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item-minimal disabled"><span class="page-link-minimal">&lsaquo;</span></li>
        @else
            <li class="page-item-minimal"><a class="page-link-minimal" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item-minimal disabled"><span class="page-link-minimal ellipsis">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item-minimal active"><span class="page-link-minimal">{{ $page }}</span></li>
                    @else
                        <li class="page-item-minimal"><a class="page-link-minimal" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item-minimal"><a class="page-link-minimal" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
        @else
            <li class="page-item-minimal disabled"><span class="page-link-minimal">&rsaquo;</span></li>
        @endif
    </ul>
</nav>
@endif
