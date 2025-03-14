@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
                <div class="flex flex-col items-center">
                    <div class="flex justify-center w-full">
                        <img id="showImage"
                            src="{{ !empty($adminData->photo) ? url('upload/admin_images/' . $adminData->photo) : url('https://placeholds.co/600x600') }}"
                            alt="Admin Photo" class="w-32 h-32 object-cover rounded mb-4">
                    </div>
                    <div class="">
                        <h3 class="text-xl font-semibold">Username: {{ $adminData->username ?? 'Admin Name' }}</h3>
                        <h3 class="text-xl font-semibold">Name: {{ $adminData->name ?? 'Admin Name' }}</h3>
                        <p class="text-gray-500">User Email: {{ $adminData->email ?? 'admin@example.com' }}</p>
                        <p class="text-gray-500">User Phone: {{ $adminData->phone ?? 'admin@example.com' }}</p>
                        <p class="text-gray-500"> User Address: {{ $adminData->address ?? 'admin@example.com' }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="text-lg font-semibold">Profile Information</div>
                        <div class="text-sm font-medium text-gray-400">Update your profile information</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">


                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">User Name</label>
                            <input type="text" name="username" value="{{ old('username', $adminData->username ?? '') }}"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500 focus:border-none ">
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $adminData->name ?? '') }}"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500 focus:border-none">
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $adminData->email ?? '') }}"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500 focus:border-none">
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone', $adminData->phone ?? '') }}"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500 focus:border-none"
                                pattern="[0-9]*" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                onkeypress="return /[0-9]/i.test(event.key)" inputmode="numeric">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea name="address" rows="3"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500 focus:border-none">{{ old('address', $adminData->address ?? '') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1 text-center md:text-left">Profile
                                Image</label>
                            <div class="flex justify-center md:justify-start md:mr-4 md:mb-4" id="single-image-upload">
                                <div id="drop-area-single"
                                    class="border-2 border-dashed border-gray-400 p-6 w-32 h-32 text-center rounded-lg cursor-pointer hover:border-orange-500 relative"
                                    ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                    ondrop="handleDrop(event)"
                                    onclick="document.getElementById('file-input-single').click()">
                                    <div id="upload-text-single" class="text-gray-600">
                                        <i class="fas fa-cloud-upload-alt text-sm mb-2"></i>
                                        <p class="text-[11px]">Drag & Drop image here or click to upload</p>
                                        <p class="text-[9px] mt-1">(Max size: 5MB, Formats: JPG, PNG)</p>
                                    </div>
                                    <input type="file" id="file-input-single" name="photo" class="hidden"
                                        accept="image/jpeg,image/png" onchange="handleFile(this.files[0])">
                                    <img id="image-preview-single"
                                        class="hidden w-full h-full absolute top-0 left-0 object-cover rounded-lg p-1"
                                        alt="Profile preview">
                                    <div id="loading-indicator"
                                        class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="bg-orange-500 text-white py-2 px-6 rounded hover:bg-orange-600 transition duration-200">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
