@if ($paginator->hasPages())
    @php
        $classBtn = 'btn btn-outline-info rounded-pill';
    @endphp
    <style>
        .page-link {
            border-color: transparent;
            background-color: transparent;
            color:  #0049fc;
        }
        .page-link:hover {
            border-color: transparent;
            background-color: transparent;
            color:  #fff;
        }
        .btn.disabled.hover {
            border-color: transparent;
            background-color: transparent;
            color:  #fff;
        }
        .page-item:hover {
            color:  #fff;
        }
    </style>
    <nav role="navigation" aria-label="{!! __('Pagination Navigation') !!}">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item {{$classBtn}} disabled" aria-disabled="true">
                    <span style="background: none;
                    background-color: transparent;
                    border: transparent;" class="page-link">{!! __('pagination.previous') !!}</span>
                </li>
            @else
                <li class="page-item {{$classBtn}}">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        {!! __('pagination.previous') !!}
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item {{$classBtn}}">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">{!! __('pagination.next') !!}</a>
                </li>
            @else
                <li class="page-item {{$classBtn}} disabled" aria-disabled="true">
                    <span style="background: none;
                    background-color: transparent;
                    border: transparent;" class="page-link">{!! __('pagination.next') !!}</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
