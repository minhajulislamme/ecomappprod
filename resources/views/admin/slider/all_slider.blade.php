@extends('admin.admin_dashboard')

@section('admin_content')
    <!-- start data table  -->
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">

            <div class="flex justify-between mb-4 items-start">
                <div>
                    <div class="text-lg font-semibold">Slider Data Table </div>
                    <div class="text-sm font-medium text-gray-400">All Slider list </div>
                </div>
                <div class="dropdown">
                    <button type="button"
                        class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                        <i class="ri-more-2-fill"></i>
                    </button>
                    <div
                        class="dropdown-menu hidden shadow-md shadow-black/5 z-30 w-full max-w-[140px] bg-white rounded-md border border-gray-100">
                        <ul>

                            <li>
                                <a href="{{route('slider.add')}}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-menu-add-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Add Slider</span>
                                </a>
                            </li>
                            


                        </ul>
                    </div>

                </div>
            </div>
            <div class="flex justify-between mb-4 items-start">
                <div>
                    <!-- <label for="perPage" class="mr-2 text-sm text-blue-500">show per page</label> -->
                    <select id="perPage"
                        class="border border-gray-100 p-2 mr-2 bg-gray-50 rounded-md text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M11.9997%2013.1714L16.9495%208.22168L18.3637%209.63589L11.9997%2015.9999L5.63574%209.63589L7.04996%208.22168L11.9997%2013.1714Z%22%20fill%3D%22%23A3A3A3%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-right-0.5 pr-5">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>
                <div>
                    <div class="relative w-full mr-2">
                        <input id="searchInput" type="text"
                            class="py-2 pr-4 pl-10 bg-gray-50 outline-none border border-gray-100 w-full rounded-md text-sm transition-all focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                            placeholder="Search...">
                        <i class="ri-search-line absolute top-1/2 left-4 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- data table  -->

            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px]" id="dataTable">
                    <thead>
                        <tr>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                SI
                            </th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                Slider
                            </th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                Status
                            </th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach ($sliders as $key => $item)
                            <tr class="data-row">
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">{{ $key + 1 }}</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="{{ asset($item->image) }}" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <span
                                            class="text-[13px] font-medium text-gray-400 ml-3">{{ $item->title }}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    @if ($item->status === 'active')
                                        <span
                                            class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">
                                            {{ $item->status }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">
                                            {{ $item->status }}
                                        </span>
                                    @endif

                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="ml-2 dropdown">
                                        <button type="button"
                                            class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                class="ri-more-2-fill"></i></button>
                                        <ul
                                            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                            <li>
                                                <a href="{{route('slider.edit',$item->id)}}"
                                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">
                                                    <i class="ri-edit-line mr-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    onclick="confirmDelete('{{route('slider.delete',$item->id)}}')"
                                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">
                                                    <i class="ri-delete-bin-line mr-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- end table  -->
            <div id="noResults" class="mt-4 text-center text-gray-500" style="display: none;">
                No results found
            </div>
            <!-- pagination  -->
            <div class="flex justify-between items-center mt-4">
                <div>
                    <span id="pageInfo" class="text-gray-400"></span>
                </div>
                <div>
                    <button id="prevPage" type="button"
                        class="text-orange-400 hover:text-orange-600 px-2 py-1 items-center  rounded-md border border-gray-100">
                        <i class="ri-arrow-left-s-line"></i>pre
                    </button>
                    <button id="nextPage" type="button"
                        class="text-orange-400 hover:text-orange-600 px-2 py-1 items-center rounded-md border border-gray-100">
                        next<i class="ri-arrow-right-s-line"></i>
                    </button>
                </div>
            </div>

            <!-- print and export button  -->
            <div class="flex justify-between items-center mt-4 hidden lg:block">
                <div>
                    <button id="printBtn" type="button"
                        class="text-orange-400 hover:text-orange-600 px-2 py-1 items-center  rounded-md border border-gray-100">
                        <i class="ri-printer-line"></i>Print
                    </button>
                    <button id="exportBtn" type="button"
                        class="text-orange-400 hover:text-orange-600 px-2 py-1 items-center  rounded-md border border-gray-100">
                        <i class="ri-file-download-line"></i>Export
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
