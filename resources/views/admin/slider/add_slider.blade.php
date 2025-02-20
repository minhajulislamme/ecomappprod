@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Add New Slider </div>
                    <div class="text-sm font-medium text-gray-400">Add new Slider to your store</div>
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
                                <a href="{{route('all.slider')}}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-file-list-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">All Slider</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </div>
            </div>
            <div>
                <form action="{{route('slider.store')}}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category Name Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slider Name</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('title') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- link  --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slider Link</label>
                            <input type="text" name="link" value="{{ old('link') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('link') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('link')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slider Image</label>
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
                                            <p class="text-[9px] mt-1">(Max size: 2MB, Formats: JPG, PNG)</p>
                                        </div>
                                        <input type="file" id="file-input-single" name="image" class="hidden"
                                            accept="image/jpeg,image/png" onchange="handleFile(this.files[0])">
                                        <img id="image-preview-single"
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
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-start pt-4">
                        <button type="submit"
                            class="px-6 py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Add Slider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add this JavaScript section at the end of the content -->
  
@endsection
