@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between align-items-center px-2 py-2">

        {{-- Mobile: simple prev/next --}}
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination pagination-sm mb-0">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="font-size:.8rem;padding:.25rem .6rem;">&#8249; Prev</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="font-size:.8rem;padding:.25rem .6rem;">&#8249; Prev</a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="font-size:.8rem;padding:.25rem .6rem;">Next &#8250;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="font-size:.8rem;padding:.25rem .6rem;">Next &#8250;</span>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Desktop: full pagination --}}
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">

            {{-- Info text --}}
            <div>
                <p class="mb-0" style="font-size:.8rem;color:#6c757d;">
                    Showing
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            {{-- Page links --}}
            <div>
                <ul class="pagination pagination-sm mb-0" style="gap:2px;">

                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true"
                                  style="font-size:.75rem;padding:.25rem .55rem;line-height:1.4;border-radius:6px;">
                                &#8249;
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                               aria-label="@lang('pagination.previous')"
                               style="font-size:.75rem;padding:.25rem .55rem;line-height:1.4;border-radius:6px;">
                                &#8249;
                            </a>
                        </li>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link"
                                      style="font-size:.75rem;padding:.25rem .5rem;line-height:1.4;border-radius:6px;">
                                    {{ $element }}
                                </span>
                            </li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link"
                                              style="font-size:.75rem;padding:.25rem .55rem;line-height:1.4;border-radius:6px;background:#860120;border-color:#860120;color:white;">
                                            {{ $page }}
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}"
                                           style="font-size:.75rem;padding:.25rem .55rem;line-height:1.4;border-radius:6px;">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                               aria-label="@lang('pagination.next')"
                               style="font-size:.75rem;padding:.25rem .55rem;line-height:1.4;border-radius:6px;">
                                &#8250;
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true"
                                  style="font-size:.75rem;padding:.25rem .55rem;line-height:1.4;border-radius:6px;">
                                &#8250;
                            </span>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
@endif
