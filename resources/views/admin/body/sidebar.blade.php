
<div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu  transition-transform">
       <a href="{{route('admin.dashboard')}}" class="flex items-center pb-4 border-b border-b-gray-800">
        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover">
        <span class="text-lg font-bold text-white ml-3"> Admin </span>
       </a>
       <ul class="mt-4">
        <li class="mb-1 group ">
            <a href="{{route('admin.dashboard')}}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md group-[.active]:bg-gray-800 sidebar-link">
                <i class="ri-dashboard-line mr-3 text-lg"></i>
                <span class="ml-2">Dashboard</span>
            </a>
        </li>
        <li class="mb-1 group">
            <a href="javascript:void()" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md  group-[.active]:bg-gray-800 sidebar-link sidebar-dropdown-toggle">
                <i class="ri-user-line mr-3 text-lg"></i>
                <span class="ml-2">Users</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                 <a href="javascript:void()" class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link">Active User</a>
                </li>
                <li class="mb-4">
                    <a href="javascript:void()" class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link">Inactive User</a>
                </li>
                <li class="mb-4">
                    <a href="javascript:void()" class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link">New User</a>
                </li>
            </ul>
        </li>
        <li class="mb-1 group">
            <a href="javascript:void()" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link  group-[.active]:bg-gray-800 sidebar-dropdown-toggle">
                <i class="ri-file-list-line mr-3 text-lg"></i>
                <span class="ml-2">Reports</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4 group">
                 <a href="javascript:void()" class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link">Monthly Report</a>
                </li>
                <li class="mb-4">
                    <a href="javascript:void()" class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link">Yearly Report</a>
                </li>
            </ul>
        </li>
        <!-- side bar single menu  -->
         <li class="mb-1 group">
            <a href="javascript:void()" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md  group-[.active]:bg-gray-800 sidebar-link">
                <i class="ri-settings-2-line mr-3 text-lg"></i>
                <span class="ml-2">Settings</span>
            </a>
        </li>
       </ul>
    </div>