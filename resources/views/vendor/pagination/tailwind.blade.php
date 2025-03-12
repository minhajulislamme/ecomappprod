@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-center my-4">
        <div class="flex rounded-md shadow">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 border border-r-0 border-gray-300 rounded-l-md text-gray-400">
                    &laquo;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-3 py-2 border border-r-0 border-gray-300 rounded-l-md text-orange-400 hover:bg-orange-50">
                    &laquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 border border-r-0 border-gray-300 text-gray-500">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 border border-r-0 border-gray-300 bg-orange-400 text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-2 border border-r-0 border-gray-300 text-gray-700 hover:bg-orange-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-2 border border-gray-300 rounded-r-md text-orange-400 hover:bg-orange-50">
                    &raquo;
                </a>
            @else
                <span class="px-3 py-2 border border-gray-300 rounded-r-md text-gray-400">
                    &raquo;
                </span>
            @endif
        </div>
    </nav>
@endif
