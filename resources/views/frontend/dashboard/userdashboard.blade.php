@extends('frontend.frontend')
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- User Profile Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="w-24 h-24 rounded-full overflow-hidden">
                    @if ($user->photo)
                        <img src="{{ asset('upload/user_images/' . $user->photo) }}" alt="{{ $user->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <img src="https://placehold.co/600x600" alt="Default Avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <p class="text-gray-500">Member since: {{ $user->created_at->format('F Y') }}</p>
                </div>
                
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Sidebar -->
            <div class="md:col-span-3">
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Dashboard Menu</h2>
                    </div>
                    <nav class="p-4">
                        <a href="#"
                            class="dashboard-tab-btn flex items-center space-x-3 text-gray-600 p-3 rounded-md hover:bg-gray-50">
                            <i class="ri-dashboard-line text-xl"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="#"
                            class="orders-tab-btn flex items-center space-x-3 text-gray-600 p-3 rounded-md hover:bg-gray-50">
                            <i class="ri-shopping-bag-line text-xl"></i>
                            <span>Orders</span>
                        </a>
                        <a href="#"
                            class="wishlist-tab-btn flex items-center space-x-3 text-gray-600 p-3 rounded-md hover:bg-gray-50">
                            <i class="ri-heart-line text-xl"></i>
                            <span>Wishlist</span>
                        </a>
                        <a href="#"
                            class="addresses-tab-btn flex items-center space-x-3 text-gray-600 p-3 rounded-md hover:bg-gray-50">
                            <i class="ri-account-box-line"></i>
                            <span>Account Settings</span>
                        </a>
                        <a href="#"
                            class="settings-tab-btn flex items-center space-x-3 text-gray-600 p-3 rounded-md hover:bg-gray-50">
                            <i class="ri-key-line text-xl"></i>
                            <span>Account Password</span>
                        </a>
                        <a href="{{ route('user.logout') }}"
                            class="flex items-center space-x-3 text-gray-600 p-3 rounded-md hover:bg-gray-50">
                            <i class="ri-logout-box-r-line"></i>
                            <span>Logout</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="md:col-span-9">
                <!-- Dashboard Tab Content -->
                <div id="dashboard-tab" class="tab-content">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <!-- Total Orders -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Orders</p>
                                    <h3 class="text-2xl font-semibold text-gray-800">25</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                                    <i class="ri-shopping-bag-line text-2xl text-orange-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Orders -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Pending Orders</p>
                                    <h3 class="text-2xl font-semibold text-gray-800">3</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <i class="ri-time-line text-2xl text-yellow-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Wishlist Items -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Wishlist Items</p>
                                    <h3 class="text-2xl font-semibold text-gray-800">12</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="ri-heart-line text-2xl text-red-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Spent -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Spent</p>
                                    <h3 class="text-2xl font-semibold text-gray-800">$1,250</h3>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="ri-money-dollar-circle-line text-2xl text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Preview -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Recent Orders</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-800">#ORD-1234</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">Jan 15, 2024</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                                Delivered
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">$250.00</td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="text-orange-400 hover:text-orange-500">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-800">#ORD-1233</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">Jan 12, 2024</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                                                Processing
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">$120.00</td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="text-orange-400 hover:text-orange-500">View Details</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Orders Tab Content -->
                <div id="orders-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">All Orders</h2>
                            <div class="flex space-x-2">
                                <select class="border rounded-md px-3 py-1 text-sm text-gray-600">
                                    <option>All Time</option>
                                    <option>Last 30 Days</option>
                                    <option>Last 6 Months</option>
                                    <option>Last Year</option>
                                </select>
                                <select class="border rounded-md px-3 py-1 text-sm text-gray-600">
                                    <option>All Status</option>
                                    <option>Processing</option>
                                    <option>Delivered</option>
                                    <option>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <!-- Orders Table -->
                        <div class="overflow-x-auto">
                            <!-- ... existing orders table structure ... -->
                        </div>
                    </div>
                </div>

                <!-- Wishlist Tab Content -->
                <div id="wishlist-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">My Wishlist</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Wishlist Item -->
                                <div class="border rounded-lg p-4 relative group">
                                    <button class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                    <img src="https://placehold.co/200x200" alt="Product"
                                        class="w-full h-48 object-cover rounded-md mb-4">
                                    <h3 class="font-semibold text-gray-800 mb-2">Product Name</h3>
                                    <p class="text-orange-500 font-semibold mb-3">$99.99</p>
                                    <button
                                        class="w-full bg-orange-400 text-white px-4 py-2 rounded-md hover:bg-orange-500 transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                                <!-- Repeat for more wishlist items -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Addresses Tab Content -->
                <div id="addresses-tab" class="tab-content hidden">
                    <!-- Add New Address Form (Initially Hidden) -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Account Settings</h2>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-6"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- Personal Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Username </label>
                                            <input type="text" name="username" value="{{ $user->username }}"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email
                                                Address</label>
                                            <input type="email" name="email" value="{{ $user->email }}"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone
                                                Number</label>
                                            <input type="tel" name="phone" value="{{ $user->phone }}"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                            <textarea name="address"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                                                rows="3">{{ $user->address }}</textarea>
                                        </div>
                                        <div class="">
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1 text-center md:text-left">Profile
                                                Image</label>
                                            <div class="flex justify-center md:justify-start md:mr-4 md:mb-4"
                                                id="single-image-upload">
                                                <div id="drop-area-single"
                                                    class="border-2 border-dashed border-gray-400 p-6 w-32 h-32 text-center rounded-lg cursor-pointer hover:border-orange-500 relative"
                                                    ondragover="handleDragOver(event)"
                                                    ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)"
                                                    onclick="document.getElementById('file-input-single').click()">
                                                    <div id="upload-text-single" class="text-gray-600">
                                                        <i class="fas fa-cloud-upload-alt text-sm mb-2"></i>
                                                        <p class="text-[11px]">Drag & Drop image here or click to upload
                                                        </p>
                                                        <p class="text-[9px] mt-1">(Max size: 5MB, Formats: JPG, PNG)</p>
                                                    </div>
                                                    <input type="file" id="file-input-single" name="photo"
                                                        class="hidden" accept="image/jpeg,image/png"
                                                        onchange="handleFile(this.files[0])">
                                                    <img id="image-preview-single"
                                                        class="hidden w-full h-full absolute top-0 left-0 object-cover rounded-lg p-1"
                                                        alt="Profile preview">
                                                    <div id="loading-indicator"
                                                        class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                                                        <div
                                                            class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="flex justify-end space-x-4">

                                    <button type="submit"
                                        class="px-6 py-2 bg-orange-400 text-white rounded-md hover:bg-orange-500">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

                <!-- Password Tab Content -->
                <div id="settings-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Account Settings</h2>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('user.password.update') }}" class="space-y-6">
                                @csrf
                                <!-- Personal Information -->


                                <!-- Password Change -->
                                <div class="pt-6 ">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                                    <div class="grid grid-cols-1 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Current
                                                Password</label>
                                            <input type="password" name="old_password"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">New
                                                Password</label>
                                            <input type="password" name="new_password"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New
                                                Password</label>
                                            <input type="password" name="new_password_confirmation"
                                                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                                        </div>
                                    </div>
                                </div>



                                <div class="flex justify-end space-x-4">

                                    <button type="submit"
                                        class="px-6 py-2 bg-orange-400 text-white rounded-md hover:bg-orange-500">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
