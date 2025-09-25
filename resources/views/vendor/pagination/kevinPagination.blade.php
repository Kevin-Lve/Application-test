<div id="" class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
    <div>
        <form method="GET" action="" id="pagination-form">
            <select name="perPage" aria-controls="kt_permissions_table" class="form-select form-select-solid form-select-sm" id="dt-length-0" onchange="document.getElementById('pagination-form').submit()">
                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <label for="dt-length-0"></label>
        </form>
    </div>
</div>

<div id="" class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
    <div class="dt-paging paging_simple_numbers">
        <nav>
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="dt-paging-button page-item disabled">
                        <button class="page-link previous" role="link" type="button" aria-controls="kt_permissions_table" aria-disabled="true" aria-label="Précédent" data-dt-idx="previous" tabindex="-1">
                            <i class="previous"></i>
                        </button>
                    </li>
                @else
                    <li class="dt-paging-button page-item">
                        <a href="{{ $paginator->previousPageUrl() }}&perPage={{ request('perPage') }}">
                            <button class="page-link previous" role="link" type="button" aria-controls="kt_permissions_table" aria-label="Précédent" data-dt-idx="previous">
                                <i class="previous"></i>
                            </button>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="dt-paging-button page-item disabled">
                            <button class="page-link" role="link" type="button">{{ $element }}</button>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage() || ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2) || $page == 1 || $page == $paginator->lastPage())
                                @if ($page == $paginator->currentPage())
                                    <li class="dt-paging-button page-item active">
                                        <button class="page-link" role="link" type="button">{{ $page }}</button>
                                    </li>
                                @else
                                    <li class="dt-paging-button page-item">
                                        <a href="{{ $url }}&perPage={{ request('perPage') }}">
                                            <button class="page-link" role="link" type="button">{{ $page }}</button>
                                        </a>
                                    </li>
                                @endif
                            @elseif ($page == 2 && $paginator->currentPage() > 4)
                                <li class="dt-paging-button page-item disabled">
                                    <button class="page-link" role="link" type="button">...</button>
                                </li>
                            @elseif ($page == $paginator->lastPage() - 1 && $paginator->currentPage() < $paginator->lastPage() - 3)
                                <li class="dt-paging-button page-item disabled">
                                    <button class="page-link" role="link" type="button">...</button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="dt-paging-button page-item">
                        <a href="{{ $paginator->nextPageUrl() }}&perPage={{ request('perPage') }}">
                            <button class="page-link next" role="link" type="button" aria-controls="kt_permissions_table" aria-label="Suivant" data-dt-idx="next">
                                <i class="next"></i>
                            </button>
                        </a>
                    </li>
                @else
                    <li class="dt-paging-button page-item disabled">
                        <button class="page-link next" role="link" type="button" aria-controls="kt_permissions_table" aria-disabled="true" aria-label="Suivant" data-dt-idx="next" tabindex="-1">
                            <i class="next"></i>
                        </button>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

<div class="dataTables_info">
    Affichage de {{ $paginator->firstItem() }} à {{ $paginator->lastItem() }} sur {{ $paginator->total() }} entrées
</div>