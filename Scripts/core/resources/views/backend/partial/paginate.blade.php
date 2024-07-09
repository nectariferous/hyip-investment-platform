@if ($paginator->hasPages())
    <div class="mt-2">
        <nav class="d-inline-block">

            <ul class="pagination mb-0">
                @if ($paginator->onFirstPage())
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">

                        </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    @if(is_array($element))
                    @foreach ($element as $key => $el)
                        <li class="page-item {{ $key == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $el }}">{{ $key }}</a>
                        </li>
                    @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">

                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
