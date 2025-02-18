@extends('admin.admin_dashboard')
@section('admin_content')
    <div class="p-6">
        <!-- top card part start  -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="text-2xl font-semibold mb-1">10</div>
                        <div class="text-sm font-medium text-gray-400">Active Order</div>
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
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-eye-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="flex items-center">
                    <div class="w-full bg-gray-100 rounded-full h4">
                        <div class="h-full bg-orange-500 rounded-full p-1" style="width: 60%;">
                            <div class="w-2 h-2 rounded-full bg-white ml-auto"></div>

                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-600 ml-4">60%</span>

                </div>
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-4">
                    <div>
                        <div class="flex items-center mb-1">
                            <div class="text-2xl font-semibold">324</div>
                            <div
                                class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2">
                                +30%</div>
                        </div>
                        <div class="text-sm font-medium text-gray-400">Visitors</div>
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
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-eye-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded-full object-cover block">
                    <img src="https://placehold.co/32x32" alt=""
                        class="w-8 h-8 rounded-full object-cover block -ml-3">
                    <img src="https://placehold.co/32x32" alt=""
                        class="w-8 h-8 rounded-full object-cover block -ml-3">
                    <img src="https://placehold.co/32x32" alt=""
                        class="w-8 h-8 rounded-full object-cover block -ml-3">
                    <img src="https://placehold.co/32x32" alt=""
                        class="w-8 h-8 rounded-full object-cover block -ml-3">
                    <img src="https://placehold.co/32x32" alt=""
                        class="w-8 h-8 rounded-full object-cover block -ml-3">
                </div>


            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="text-2xl font-semibold mb-1"><span
                                class="text-base font-normal text-gray-400 align-top">&dollar;</span>25800</div>
                        <div class="text-sm font-medium text-gray-400">Active Order</div>
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
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-eye-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <a href="javascript:void()" class="text-orange-500 font-medium text-sm hover:text-orange-600">View Details
                    All</a>
            </div>

        </div>

        <!-- top card part end  -->
        <!-- start table part  -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- right part  -->
            <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
                <div class="flex justify-between mb-4 items-start">
                    <div>
                        <div class="text-lg font-semibold">Recent Orders</div>
                        <div class="text-sm font-medium text-gray-400">List of recent orders</div>
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
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-eye-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex items-center mb-4 order-tab ">
                    <button type="button" data-tab="order" data-tab-page="active"
                        class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-tl-md rounded-bl-md hover:text-gray-600 active">Active</button>
                    <button type="button" data-tab="order" data-tab-page="completed"
                        class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4  hover:text-gray-600 ">Completed</button>
                    <button type="button" data-tab="order" data-tab-page="canceled"
                        class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-tr-md rounded-br-md hover:text-gray-600 ">Canceled</button>
                </div>
                <div class="overflow-x-auto">
                    <!-- Processing table  -->
                    <table class="w-full min-w-[540px]" data-tab-for="order" data-page="active">
                        <thead>
                            <tr>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                    Product Name</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    QTY</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    Price</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                    <!-- complete table  -->
                    <table class="w-full min-w-[540px] hidden" data-tab-for="order" data-page="completed">
                        <thead>
                            <tr>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                    Product Name</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    QTY</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    Price</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                    <!-- canceled table  -->
                    <table class="w-full min-w-[540px] hidden" data-tab-for="order" data-page="canceled">
                        <thead>
                            <tr>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                    Product Name</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    QTY</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    Price</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <div class="flex items-center justify-around mt-4">

                        <a href="javascript:void()"
                            class="text-orange-500 font-medium text-sm  hover:text-orange-600">View Details All</a>
                    </div>
                </div>



            </div>
            <!-- left part  -->
            <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
                <div class="flex justify-between mb-4 items-start">
                    <div>
                        <div class="text-lg font-semibold">Recent Deliverys</div>
                        <div class="text-sm font-medium text-gray-400">List of recent delivery</div>
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
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-eye-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex items-center mb-4 delivery-tab ">
                    <button type="button" data-tab="delivery" data-tab-page="inprocessing"
                        class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-tl-md rounded-bl-md hover:text-gray-600 active">Processing</button>
                    <button type="button" data-tab="delivery" data-tab-page="deliverys"
                        class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-tr-md rounded-br-md hover:text-gray-600 ">Completed
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <!-- Processing table  -->
                    <table class="w-full min-w-[540px]" data-tab-for="delivery" data-page="inprocessing">
                        <thead>
                            <tr>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                    Product Name</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    QTY</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    Price</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Processing</span>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                    <!-- complete table  -->
                    <table class="w-full min-w-[540px] hidden" data-tab-for="delivery" data-page="deliverys">
                        <thead>
                            <tr>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                    Product Name</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    QTY</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    Price</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-orange-500/10 text-orange-500 font-medium text-[12px] leading-none">Completed</span>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                    <!-- canceled table  -->
                    <table class="w-full min-w-[540px] hidden" data-tab-for="order" data-page="canceled">
                        <thead>
                            <tr>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                    Product Name</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    QTY</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                    Price</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class=" flex items-center">
                                        <img src="https://placehold.co/32x32" alt=""
                                            class="w-8 h-8 rounded object-cover block">
                                        <a href="javascript:void()"
                                            class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                            produts oder</a>

                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">1</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-gray-400">350$</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span
                                        class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <div class="flex items-center justify-around mt-4">

                        <a href="javascript:void()"
                            class="text-orange-500 font-medium text-sm  hover:text-orange-600">View Details All</a>
                    </div>
                </div>



            </div>
        </div>
        <!-- end table part -->

        <!-- start chart part  -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md lg:col-span-2">
                <div class="flex justify-between mb-4 items-start">
                    <div class="font-medium">Oder Statistics</div>
                    <div class="dropdown">
                        <button type="button"
                            class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                            <i class="ri-more-2-fill"></i>
                        </button>
                        <div
                            class="dropdown-menu hidden shadow-md shadow-black/5 z-30 w-full max-w-[140px] bg-white rounded-md border border-gray-100">
                            <ul>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-eye-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                        <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                        <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <div class="rounded-md border border-dashed border-gray-200 p-4">
                        <div class="flex items-center mb-0.5">
                            <div class="text-xl font-semibold">50</div>
                            <span
                                class="p-1 rounded text-[12px] font-semibold bg-emerald-500/10 text-emerald-500 leading-none ml-1">+$469</span>
                        </div>
                        <span class="text-gray-400 text-sm"> Active</span>
                    </div>
                    <div class="rounded-md border border-dashed border-gray-200 p-4">
                        <div class="flex items-center mb-0.5">
                            <div class="text-xl font-semibold">50</div>
                            <span
                                class="p-1 rounded text-[12px] font-semibold bg-orange-500/10 text-orange-500 leading-none ml-1">+$469</span>
                        </div>
                        <span class="text-gray-400 text-sm"> Completed</span>
                    </div>
                    <div class="rounded-md border border-dashed border-gray-200 p-4">
                        <div class="flex items-center mb-0.5">
                            <div class="text-xl font-semibold">50</div>
                            <span
                                class="p-1 rounded text-[12px] font-semibold bg-rose-500/10 text-rose-500 leading-none ml-1">+$469</span>
                        </div>
                        <span class="text-gray-400 text-sm"> Canceled</span>
                    </div>
                </div>
                <div>
                    <canvas id="order-chart"></canvas>
                </div>
            </div>
            <div class="bg-white border border-gray-100 shadow-sm shadow-black/5 p-6 rounded-md">
                <div class="flex justify-between mb-4 items-start">
                    <div class="font-medium">Earnings</div>
                    <div class="dropdown">
                        <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i
                                class="ri-more-fill"></i></button>
                        <ul
                            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                            <li>
                                <a href="#"
                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form class="flex items-center mb-4" action="">
                    <div class="relative w-full mr-2">
                        <input type="text"
                            class="py-2  pr-4 pl-10 bg-gray-50 outline-none border border-gray-100 w-full rounded-md text-sm focus:border-orange-500 "
                            placeholder="Search...">
                        <i class="ri-search-line absolute top-1/2 left-4 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[460px]">
                        <thead>
                            <tr>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                    Review</th>
                                <th
                                    class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                    Stauts</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover block">
                                        <a href="#"
                                            class=" text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Products
                                            Reviews</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-[13px] font-medium text-gray-400"> 1K</span>
                                        </div>
                                        <div class="ml-2 dropdown">
                                            <button type="button"
                                                class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i
                                                    class="ri-more-2-fill"></i></button>
                                            <ul
                                                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-orange-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                        </tbody>

                    </table>
                    <div class="flex justify-center mt-4">
                        <div>
                            <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium">View
                                All</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end chart part  -->

        <!-- start data table  -->
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">

            <div class="flex justify-between mb-4 items-start">
                <div>
                    <div class="text-lg font-semibold">Oder Data Table </div>
                    <div class="text-sm font-medium text-gray-400">All Oder list </div>
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
                                <a href="#" class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-eye-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="flex justify-between mb-4 items-start">
                <div>
                    <!-- <label for="perPage" class="mr-2 text-sm text-blue-500">show per page</label> -->
                    <select id="perPage" class="border border-gray-100 p-2.5  mr-2 bg-gray-50 rounded-md text-sm">
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
                            class="py-2  pr-4 pl-10 bg-gray-50 outline-none border border-gray-100 w-full rounded-md text-sm focus:border-orange-500 "
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
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">
                                Product</th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                Quantity</th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">
                                Price</th>
                            <th
                                class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">

                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        minhaz oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">minhajul</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        sahin oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">alamin</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>
                        <tr class="data-row">
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <div class=" flex items-center">
                                    <img src="https://placehold.co/32x32" alt=""
                                        class="w-8 h-8 rounded object-cover block">
                                    <a href="javascript:void()"
                                        class="text-gray-600 text-sm font-medium hover:text-orange-500 ml-2 truncate">Test
                                        produts oder</a>

                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">1</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span class="text-[13px] font-medium text-gray-400">350$</span>
                            </td>
                            <td class="py-2 px-4 border-b border-b-gray-50">
                                <span
                                    class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                            </td>
                        </tr>



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

        <!-- end data table  -->

        <!-- start form part  -->
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Add New Product</div>
                    <div class="text-sm font-medium text-gray-400">Add new product to your store</div>
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
                                <a href="#"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-eye-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <!-- form part  -->
                <form action="" class="space-y-4">
                    <!-- billing Details -->
                    <div class="">
                        <h3 class="text-lg font-medium mb-2">Billing Details</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <input type="text" placeholder="First Name"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500">
                            <input type="text" placeholder="Last Name"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500">
                            <input type="number" placeholder="Phone Number"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 md:col-span-2"
                                onkeypress="validateNumberInput(event)" onpaste="return false"">
                            <input type="email" placeholder="Email Address"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 md:col-span-2">
                        </div>
                    </div>
                    <!-- shipping Details -->
                    <div>
                        <h3 class="text-lg font-medium mb-2">Shipping Details</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <input type="text" placeholder="Address"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 md:col-span-3">
                            <select name="" id=""
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500  ">
                                <option value="">Select City</option>
                                <option value="">Dhaka</option>
                                <option value="">Chittograme</option>
                                <option value="">Comila</option>
                                <option value="">Sylhet</option>
                            </select>
                            <input type="text" placeholder="Post Office"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500">
                            <input type="text" placeholder="Zip Code"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500">
                        </div>
                    </div>
                    <!-- additonal information  -->
                    <div>
                        <h3 class="text-lg font-medium mb-2">Additional Information</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <textarea name="" id="" cols="30" rows="5" placeholder="Order Notes"
                                class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 md:col-span-2"></textarea>
                        </div>
                    </div>

                    <!-- payment method  -->
                    <div>
                        <h3 class="text-lg font-medium mb-2">Payment Method</h3>
                        <div class="border border-gray-100 p-2.5 bg-gray-50  rounded-md w-full text-sm">
                            <label class="flex items-center spacex-2 mb-2">
                                <input type="radio" name="payment" class="mr-2" value="cod" checked
                                    onclick="togglePaymentMethod()">
                                <span>Cash on Delivery</span>
                            </label>
                            <label class="flex items-center spacex-2 mb-2">
                                <input type="radio" name="payment" class="mr-2" value="mobilebanking"
                                    onclick="togglePaymentMethod()">
                                <span>Mobile banking</span>
                            </label>
                            <label class="flex items-center spacex-2 mb-2">
                                <input type="radio" name="payment" class="mr-2" value="credit"
                                    onclick="togglePaymentMethod()">
                                <span>Card Payment</span>
                            </label>


                            <div id="mobilebanking" class="payment-option mt-2 hidden">
                                <input type="text" placeholder="Bkash Number"
                                    class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 mb-2">
                                <input type="text" placeholder="Bkash Tran ID"
                                    class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 mb-2">

                            </div>
                            <div id="credit" class="payment-option mt-2 hidden">
                                <input type="text" placeholder="Card Number"
                                    class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 mb-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <input type="text" placeholder="Expiry Date (MM/YY)"
                                        class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 mb-2">
                                    <input type="text" placeholder="CVV"
                                        class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 mb-2">
                                </div>
                            </div>
                            <div id="cod" class="payment-option mt-2 ">
                                <p class="text-sm text-gray-600">You will pay at the time of delivery.</p>
                            </div>

                        </div>
                    </div>

                    <!-- submit button  -->
                    <!-- Submit Button -->
                    <div class=" flex justify-start mt-4">
                        <div>
                            <button type="submit"
                                class="bg-orange-600 text-white py-2 px-4 rounded w-full hover:bg-orange-700">
                                Place Order
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

        <!-- end form part  -->

        <!-- start Addtional  part  -->

        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Add Additional part</div>
                    <div class="text-sm font-medium text-gray-400">Add new product to your store</div>
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
                                <a href="#"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-eye-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">View</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-pencil-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Edit</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-delete-bin-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Delete</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <form action="" class="space-y-4">
                    <div class ="flex flex-col md:flex-row justify-center  lg:justify-start mb-6 ">

                        <!-- single imgae uploade  -->


                        <div class="mr-4 mb-4" id="single-image-upload">
                            <div id="drop-area-single"
                                class="border-2 border-dashed border-gray-400 p-6 w-64 h-64 text-center rounded-lg cursor-pointer hover:border-orange-500 relative"
                                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                ondrop="handleDropSingle(event)"
                                onclick="document.getElementById('file-input-single').click()">
                                <p id="upload-text-single"class="text-gray-600">Drag &Drop image here or click to upload
                                </p>
                                <input type="file" id="file-input-single" class="hidden" accept="image/*"
                                    onchange="previewSingleImage(event)">
                                <img id="image-preview-single"
                                    class="hidden  w-64 h-64 absolute p-2 top-0 left-0 object-cover rounded-lg overflow-hidden">
                            </div>

                        </div>
                        <!-- multiple-image-upload  -->
                        <div id="multiple-image-upload" class="mr-4">
                            <div id="drop-area-multiple"
                                class="border-2 border-dashed border-gray-400 p-6 w-32 h-32 text-center rounded-lg cursor-pointer hover:border-orange-500 relative"
                                oondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                ondrop="handleDropMultiple(event)"
                                onclick="document.getElementById('file-input-multiple').click()">
                                <p id="upload-text-single"class=" text-xs text-gray-600">Drag &Drop image here or click to
                                    upload</p>

                                <input id="file-input-multiple" type="file" class="hidden" accept="image/*"
                                    multiple onchange="previewMultipleImages(event)">
                            </div>
                            <div id="image-previews"
                                class="flex flex-wrap  mt-4 rounded-md justify-center lg:justify-start mb-6">
                                <!-- Image previews will be inserted here -->
                            </div>

                        </div>


                    </div>
                    <div class="editor-container">
                        <div id="editor"></div>
                        <input type="hidden" name="content" id="content">
                    </div>
            
                </form>
            </div>
        </div>



    </div>
@endsection

