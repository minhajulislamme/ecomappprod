@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white shadow-md rounded-md border border-gray-100">
            <!-- Header section -->
            <div class="flex justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold">Subcategories</h2>
                    <p class="text-sm text-gray-500">Manage your subcategories</p>
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
                                <a href="{{ route('subcategory.add') }}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-menu-add-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Add</span>
                                </a>
                            </li>
                            


                        </ul>
                    </div>

                </div>
               
            </div>

            <!-- Table section -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px]">
                    <thead>
                        <tr>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                SI
                            </th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                Category Name
                            </th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                Sub Category Name
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
                    <tbody>
                        @forelse($subcategories as $key => $item)
                            <tr data-id="{{ $item->id }}">
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">{{ $key + 1 }}</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <span
                                            class="text-[13px] font-medium text-gray-400 ml-3">{{ $item->category->category_name }}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <span
                                            class="text-[13px] font-medium text-gray-400 ml-3">{{ $item->subcategory_name }}</span>
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
                                                <a href="{{ route('subcategory.edit', $item->id) }}"
                                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">
                                                    <i class="ri-edit-line mr-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    onclick="confirmDelete('{{ route('subcategory.delete', $item->id) }}')"
                                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">
                                                    <i class="ri-delete-bin-line mr-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">
                                    No subcategories found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
