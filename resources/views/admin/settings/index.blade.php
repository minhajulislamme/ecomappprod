@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="max-w-7xl mx-auto px-4 py-6">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-semibold text-gray-800">Tracking Settings</h1>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                                <p class="font-bold">Please fix the following errors:</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <label for="facebook_pixel_id" class="block text-gray-700 text-sm font-bold mb-2">Facebook
                                    Pixel ID</label>
                                <input type="text" name="facebook_pixel_id" id="facebook_pixel_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    value="{{ old('facebook_pixel_id', $settings['facebook_pixel_id']) }}"
                                    placeholder="Enter your Facebook Pixel ID">
                                <p class="text-gray-500 text-xs mt-1">Example: 123456789012345</p>
                            </div>

                            <div class="mb-6">
                                <label for="google_tag_manager_id" class="block text-gray-700 text-sm font-bold mb-2">Google
                                    Tag Manager ID</label>
                                <input type="text" name="google_tag_manager_id" id="google_tag_manager_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    value="{{ old('google_tag_manager_id', $settings['google_tag_manager_id']) }}"
                                    placeholder="Enter your Google Tag Manager ID">
                                <p class="text-gray-500 text-xs mt-1">Example: GTM-XXXXXXX</p>
                            </div>

                            <div class="flex items-center justify-end">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
