@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Edit Banner</div>
                    <div class="text-sm font-medium text-gray-400">Update existing Banner</div>
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
                                <a href="{{ route('banner.add') }}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-menu-add-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">Add</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.banner') }}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-file-list-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">All Banner</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </div>
            </div>
            <div>
                <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">banner Name</label>
                            <input type="text" name="title" value="{{ $banner->title }}"
                                placeholder="Enter banner title"
                                class="w-full px-4 py-2 border @error('title') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">banner Link</label>
                            <input type="text" name="link" value="{{ $banner->link }}" placeholder="Enter banner link"
                                class="w-full px-4 py-2 border @error('link') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('link')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">banner Image</label>
                            <div class="">


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
                                        <input type="file" id="file-input-single" name="image" class="hidden"
                                            accept="image/jpeg,image/png" onchange="handleFile(this.files[0])">
                                        <img id="image-preview-single" src="{{ asset($banner->image) }}"
                                            class="hidden w-full h-full absolute top-0 left-0 object-cover rounded-lg p-1"
                                            alt="Profile preview">
                                        <div id="loading-indicator"
                                            class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500">
                                            </div>
                                        </div>
                                        @error('image')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- Status Toggle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Subcategory Status</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="status" value="inactive">
                                <input type="checkbox" name="status" value="active" class="sr-only peer"
                                    {{ old('status', $banner->status) == 'active' ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-orange-300 rounded-full peer 
                                    peer-checked:after:translate-x-full peer-checked:after:border-white 
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                    after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                    {{ old('status', $banner->status) == 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-start pt-4">
                        <button type="submit"
                            class="px-6 py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Update banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
