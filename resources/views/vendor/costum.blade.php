@if ($paginator->hasPages())
    <div class="pagination d-flex justify-content-center mt-5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="rounded disabled" aria-disabled="true">&laquo;</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Three Dots --}}
            @if (is_string($element))
                <a class="rounded disabled">{{ $element }}</a>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="rounded active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="rounded">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded">&raquo;</a>
        @else
            <a class="rounded disabled" aria-disabled="true">&raquo;</a>
        @endif
    </div>
@endif
